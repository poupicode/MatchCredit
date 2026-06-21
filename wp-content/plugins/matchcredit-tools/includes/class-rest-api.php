<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Endpoint de calcul temps réel pour le widget frontend. Appelle le même
 * MC_Tools_Renderer::compute() que le fallback no-JS — une seule logique
 * de calcul, le PHP reste la source de vérité (cf. cadrage section 12).
 *
 * Lecture seule (aucune écriture de contenu), public par design : un
 * visiteur doit pouvoir obtenir un résultat sans être connecté.
 */
class MC_Tools_Rest_Api {

	public static function init() {
		add_action( 'rest_api_init', array( __CLASS__, 'register_routes' ) );
	}

	public static function register_routes() {
		register_rest_route(
			'matchcredit/v1',
			'/compute',
			array(
				'methods'             => 'POST',
				'callback'            => array( __CLASS__, 'compute' ),
				'permission_callback' => '__return_true',
				'args'                => array(
					'slug'   => array( 'required' => true, 'type' => 'string' ),
					'values' => array( 'required' => true, 'type' => 'object' ),
				),
			)
		);

		register_rest_route(
			'matchcredit/v1',
			'/presets',
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'list_presets' ),
				'permission_callback' => array( __CLASS__, 'can_manage' ),
			)
		);

		register_rest_route(
			'matchcredit/v1',
			'/tools/(?P<id>\d+)',
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'get_tool' ),
				'permission_callback' => array( __CLASS__, 'can_manage' ),
			)
		);

		register_rest_route(
			'matchcredit/v1',
			'/tools/(?P<id>\d+)',
			array(
				'methods'             => 'POST',
				'callback'            => array( __CLASS__, 'save_tool' ),
				'permission_callback' => array( __CLASS__, 'can_manage' ),
			)
		);

		register_rest_route(
			'matchcredit/v1',
			'/preview',
			array(
				'methods'             => 'POST',
				'callback'            => array( __CLASS__, 'preview' ),
				'permission_callback' => array( __CLASS__, 'can_manage' ),
			)
		);
	}

	/**
	 * Calcule un résultat à partir d'une config NON sauvegardée (utilisé par
	 * l'aperçu live du builder admin pendant l'édition).
	 */
	public static function preview( WP_REST_Request $request ) {
		$config = $request->get_param( 'config' );
		$values = (array) $request->get_param( 'values' );

		if ( ! is_array( $config ) ) {
			return new WP_Error( 'mc_tool_invalid_config', __( 'Configuration invalide.', 'matchcredit-tools' ), array( 'status' => 422 ) );
		}

		$sanitized = array();
		foreach ( ( $config['fields'] ?? array() ) as $field ) {
			if ( isset( $values[ $field['id'] ] ) ) {
				$raw = $values[ $field['id'] ];
				$sanitized[ $field['id'] ] = in_array( $field['type'], array( 'select', 'radio_cards' ), true )
					? sanitize_text_field( (string) $raw )
					: (float) $raw;
			}
		}

		try {
			$results = MC_Tools_Renderer::compute( $config, $sanitized );
		} catch ( InvalidArgumentException $e ) {
			return new WP_Error( 'mc_tool_compute_error', $e->getMessage(), array( 'status' => 422 ) );
		}

		return rest_ensure_response( array( 'results' => $results ) );
	}

	public static function can_manage(): bool {
		return current_user_can( 'manage_options' );
	}

	public static function list_presets(): WP_REST_Response {
		return rest_ensure_response( array_values( MC_Tools_Presets::describe() ) );
	}

	public static function get_tool( WP_REST_Request $request ) {
		$post_id = (int) $request->get_param( 'id' );
		$post    = get_post( $post_id );

		if ( ! $post || MC_Tools_CPT::POST_TYPE !== $post->post_type ) {
			return new WP_Error( 'mc_tool_not_found', __( 'Calculette introuvable.', 'matchcredit-tools' ), array( 'status' => 404 ) );
		}

		$config = MC_Tools_Renderer::get_config( $post_id ) ?? array(
			'type'    => 'calculette',
			'preset'  => 'pret_amortissable',
			'fields'  => array(),
			'results' => array(),
			'cta'     => array( 'text' => '', 'url' => '' ),
		);

		return rest_ensure_response(
			array(
				'id'     => $post_id,
				'slug'   => $post->post_name,
				'title'  => $post->post_title,
				'config' => $config,
			)
		);
	}

	public static function save_tool( WP_REST_Request $request ) {
		$post_id = (int) $request->get_param( 'id' );
		$post    = get_post( $post_id );

		if ( ! $post || MC_Tools_CPT::POST_TYPE !== $post->post_type ) {
			return new WP_Error( 'mc_tool_not_found', __( 'Calculette introuvable.', 'matchcredit-tools' ), array( 'status' => 404 ) );
		}

		$config = $request->get_param( 'config' );

		if ( ! is_array( $config ) ) {
			return new WP_Error( 'mc_tool_invalid_config', __( 'Configuration invalide.', 'matchcredit-tools' ), array( 'status' => 422 ) );
		}

		try {
			self::validate_config( $config );
		} catch ( InvalidArgumentException $e ) {
			return new WP_Error( 'mc_tool_invalid_config', $e->getMessage(), array( 'status' => 422 ) );
		}

		MC_Tools_Renderer::save_config( $post_id, $config );

		return rest_ensure_response( array( 'saved' => true ) );
	}

	/**
	 * Validation du schéma avant sauvegarde — jamais de config invalide
	 * persistée silencieusement (cf. cadrage section 6 et 15).
	 *
	 * @param array<string,mixed> $config
	 * @throws InvalidArgumentException
	 */
	private static function validate_config( array $config ): void {
		if ( ! in_array( $config['type'] ?? '', array( 'calculette', 'simulation' ), true ) ) {
			throw new InvalidArgumentException( 'Type invalide : "calculette" ou "simulation" attendu.' );
		}

		$field_ids = array();
		foreach ( ( $config['fields'] ?? array() ) as $field ) {
			if ( empty( $field['id'] ) || empty( $field['label'] ) || empty( $field['type'] ) ) {
				throw new InvalidArgumentException( 'Chaque champ doit avoir un id, un label et un type.' );
			}
			if ( ! in_array( $field['type'], array( 'number', 'slider', 'select', 'radio_cards', 'toggle' ), true ) ) {
				throw new InvalidArgumentException( sprintf( 'Type de champ invalide : "%s".', $field['type'] ) );
			}
			$field_ids[] = $field['id'];
		}

		if ( 'custom' === ( $config['preset'] ?? '' ) ) {
			if ( empty( $config['formula'] ) ) {
				throw new InvalidArgumentException( 'Une formule personnalisée est requise.' );
			}
			MC_Tools_Formula_Parser::validate( $config['formula'], $field_ids );
		} elseif ( ! in_array( $config['preset'] ?? '', MC_Tools_Presets::slugs(), true ) ) {
			throw new InvalidArgumentException( sprintf( 'Preset inconnu : "%s".', $config['preset'] ?? '' ) );
		}

		foreach ( ( $config['results'] ?? array() ) as $result ) {
			if ( empty( $result['key'] ) || empty( $result['label'] ) || empty( $result['format'] ) ) {
				throw new InvalidArgumentException( 'Chaque résultat doit avoir une clé, un label et un format.' );
			}
		}
	}

	public static function compute( WP_REST_Request $request ) {
		$slug   = sanitize_title( $request->get_param( 'slug' ) );
		$values = (array) $request->get_param( 'values' );

		$post = get_page_by_path( $slug, OBJECT, MC_Tools_CPT::POST_TYPE );

		if ( ! $post ) {
			return new WP_Error( 'mc_tool_not_found', __( 'Calculette introuvable.', 'matchcredit-tools' ), array( 'status' => 404 ) );
		}

		$config = MC_Tools_Renderer::get_config( $post->ID );

		if ( ! $config ) {
			return new WP_Error( 'mc_tool_no_config', __( 'Calculette non configurée.', 'matchcredit-tools' ), array( 'status' => 422 ) );
		}

		$sanitized = array();
		foreach ( $config['fields'] as $field ) {
			if ( isset( $values[ $field['id'] ] ) ) {
				$raw = $values[ $field['id'] ];
				$sanitized[ $field['id'] ] = in_array( $field['type'], array( 'select', 'radio_cards' ), true )
					? sanitize_text_field( (string) $raw )
					: (float) $raw;
			}
		}

		try {
			$results = MC_Tools_Renderer::compute( $config, $sanitized );
		} catch ( InvalidArgumentException $e ) {
			return new WP_Error( 'mc_tool_compute_error', $e->getMessage(), array( 'status' => 422 ) );
		}

		return rest_ensure_response( array( 'results' => $results ) );
	}
}
