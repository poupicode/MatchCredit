<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Point d'entrée commun de rendu. Le shortcode, le futur bloc Gutenberg et
 * l'appel PHP direct depuis le thème appellent tous mc_tools_render() — la
 * logique de calcul/markup n'existe qu'ici, jamais dupliquée.
 */
class MC_Tools_Renderer {

	const META_KEY = '_mc_tool_config';
	const NONCE_ACTION = 'mc_tools_compute';

	/**
	 * @param array{echo?:bool} $args
	 */
	public static function render( string $slug, array $args = array() ): string {
		$post = self::get_tool_by_slug( $slug );

		if ( ! $post ) {
			return '';
		}

		$config = self::get_config( $post->ID );

		if ( ! $config ) {
			return '';
		}

		wp_enqueue_script( 'mc-tools-widget' );
		wp_enqueue_style( 'mc-tools-widget' );

		$values  = self::default_values( $config );
		$results = null;
		$error   = null;

		// Fallback no-JS : POST direct sur la page contenant le shortcode.
		if ( isset( $_POST['mc_tool_slug'] ) && sanitize_title( wp_unslash( $_POST['mc_tool_slug'] ) ) === $slug ) {
			if ( ! isset( $_POST['mc_tool_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mc_tool_nonce'] ) ), self::NONCE_ACTION ) ) {
				$error = __( 'Session expirée, veuillez réessayer.', 'matchcredit-tools' );
			} else {
				$values = self::values_from_request( $config, $values );
				try {
					$results = self::compute( $config, $values );
				} catch ( InvalidArgumentException $e ) {
					$error = $e->getMessage();
				}
			}
		}

		$html = self::render_markup( $slug, $config, $values, $results, $error );

		if ( $args['echo'] ?? false ) {
			echo $html; // phpcs:ignore -- markup déjà échappé champ par champ dans render_markup().
			return '';
		}

		return $html;
	}

	private static function get_tool_by_slug( string $slug ): ?WP_Post {
		$post = get_page_by_path( $slug, OBJECT, MC_Tools_CPT::POST_TYPE );
		return $post instanceof WP_Post ? $post : null;
	}

	/** @return array<string,mixed>|null */
	public static function get_config( int $post_id ): ?array {
		$raw = get_post_meta( $post_id, self::META_KEY, true );

		if ( ! $raw ) {
			return null;
		}

		$config = json_decode( $raw, true );
		return is_array( $config ) ? $config : null;
	}

	/** @param array<string,mixed> $config */
	public static function save_config( int $post_id, array $config ): void {
		// JSON_UNESCAPED_UNICODE : évite les é que update_post_meta()
		// dénature en "u00e9" via son stripslashes interne.
		update_post_meta( $post_id, self::META_KEY, wp_json_encode( $config, JSON_UNESCAPED_UNICODE ) );
	}

	/**
	 * @param array<string,mixed> $config
	 * @return array<string,float|string>
	 */
	private static function default_values( array $config ): array {
		$values = array();

		foreach ( $config['fields'] as $field ) {
			$values[ $field['id'] ] = $field['default'] ?? '';
		}

		return $values;
	}

	/**
	 * @param array<string,mixed> $config
	 * @param array<string,mixed> $values
	 * @return array<string,mixed>
	 */
	private static function values_from_request( array $config, array $values ): array {
		foreach ( $config['fields'] as $field ) {
			$key = 'mc_field_' . $field['id'];
			if ( isset( $_POST[ $key ] ) ) {
				$raw = sanitize_text_field( wp_unslash( $_POST[ $key ] ) );
				$values[ $field['id'] ] = in_array( $field['type'], array( 'select', 'radio_cards' ), true )
					? $raw
					: (float) $raw;
			} elseif ( 'toggle' === $field['type'] ) {
				$values[ $field['id'] ] = 0;
			}
		}

		return $values;
	}

	/**
	 * Source de vérité unique du calcul, partagée par le rendu serveur
	 * (fallback no-JS) et la validation admin. Le widget JS frontend
	 * recalcule la même chose côté client avec mathjs, pour le confort
	 * temps réel, mais ne remplace jamais ce calcul serveur.
	 *
	 * @param array<string,mixed> $config
	 * @param array<string,mixed> $values
	 * @return array<string,float>
	 */
	public static function compute( array $config, array $values ): array {
		$variables = array();
		foreach ( $config['fields'] as $field ) {
			$raw = $values[ $field['id'] ] ?? null;

			if ( in_array( $field['type'] ?? '', array( 'select', 'radio_cards' ), true ) ) {
				$variables[ $field['id'] ] = (string) ( $raw ?? '' );
				continue;
			}

			// '' (champ vide/non fourni) doit rester absent (null), pas devenir 0 —
			// sinon les presets ne peuvent plus distinguer "non fourni" de "vaut zéro"
			// et leurs garde-fous sur `null === $variable` ne se déclenchent jamais.
			$variables[ $field['id'] ] = ( null !== $raw && '' !== $raw && is_numeric( $raw ) ) ? (float) $raw : null;
		}

		if ( 'custom' === $config['preset'] ) {
			$numeric_vars = array_filter( $variables, 'is_numeric' );
			$parser       = new MC_Tools_Formula_Parser( $config['formula'] );
			$value        = $parser->evaluate( $numeric_vars );
			$result_key   = $config['results'][0]['key'] ?? 'resultat';
			return array( $result_key => $value );
		}

		$preset = MC_Tools_Presets::get( $config['preset'] );
		return $preset->compute( $variables );
	}

	/**
	 * @param array<string,mixed> $config
	 * @param array<string,mixed> $values
	 * @param array<string,float>|null $results
	 */
	private static function render_markup( string $slug, array $config, array $values, ?array $results, ?string $error ): string {
		ob_start();
		$nonce = wp_create_nonce( self::NONCE_ACTION );
		$config_json = wp_json_encode( $config );
		?>
		<form class="mc-tool" data-mc-tool data-slug="<?php echo esc_attr( $slug ); ?>" data-config="<?php echo esc_attr( $config_json ); ?>" method="post">
			<input type="hidden" name="mc_tool_slug" value="<?php echo esc_attr( $slug ); ?>" />
			<input type="hidden" name="mc_tool_nonce" value="<?php echo esc_attr( $nonce ); ?>" />

			<?php if ( $error ) : ?>
				<p class="mc-tool__error"><?php echo esc_html( $error ); ?></p>
			<?php endif; ?>

			<div class="mc-tool__fields">
				<?php foreach ( $config['fields'] as $field ) : ?>
					<?php self::render_field( $field, $values[ $field['id'] ] ?? '' ); ?>
				<?php endforeach; ?>
			</div>

			<div class="mc-tool__results" data-mc-results>
				<?php foreach ( $config['results'] as $result ) : ?>
					<div class="mc-tool__result<?php echo ! empty( $result['highlight'] ) ? ' mc-tool__result--highlight' : ''; ?>" data-mc-result="<?php echo esc_attr( $result['key'] ); ?>">
						<span class="mc-tool__result-label"><?php echo esc_html( $result['label'] ); ?></span>
						<span class="mc-tool__result-value">
							<?php echo isset( $results[ $result['key'] ] ) ? esc_html( self::format( $results[ $result['key'] ], $result['format'] ) ) : '—'; ?>
						</span>
					</div>
				<?php endforeach; ?>
			</div>

			<noscript><button type="submit" class="mc-tool__submit"><?php esc_html_e( 'Calculer', 'matchcredit-tools' ); ?></button></noscript>

			<?php if ( ! empty( $config['cta']['text'] ) ) : ?>
				<a class="mc-tool__cta" href="<?php echo esc_url( $config['cta']['url'] ?? '#' ); ?>"><?php echo esc_html( $config['cta']['text'] ); ?></a>
			<?php endif; ?>
		</form>
		<?php
		return (string) ob_get_clean();
	}

	/** @param array<string,mixed> $field */
	private static function render_field( array $field, $value ): void {
		$id   = esc_attr( $field['id'] );
		$name = 'mc_field_' . $field['id'];
		?>
		<div class="mc-tool__field" data-mc-field="<?php echo $id; ?>">
			<label class="mc-tool__label" for="mc-field-<?php echo $id; ?>"><?php echo esc_html( $field['label'] ); ?></label>
			<?php
			switch ( $field['type'] ) {
				case 'select':
					?>
					<select class="mc-tool__select" id="mc-field-<?php echo $id; ?>" name="<?php echo esc_attr( $name ); ?>">
						<?php foreach ( $field['options'] as $option ) : ?>
							<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $value, $option['value'] ); ?>><?php echo esc_html( $option['label'] ); ?></option>
						<?php endforeach; ?>
					</select>
					<?php
					break;

				case 'toggle':
					?>
					<input class="mc-tool__toggle" type="checkbox" id="mc-field-<?php echo $id; ?>" name="<?php echo esc_attr( $name ); ?>" value="1" <?php checked( (bool) $value ); ?> />
					<?php
					break;

				case 'slider':
					?>
					<input class="mc-tool__slider" type="range" id="mc-field-<?php echo $id; ?>" name="<?php echo esc_attr( $name ); ?>"
						min="<?php echo esc_attr( $field['min'] ?? 0 ); ?>" max="<?php echo esc_attr( $field['max'] ?? 100 ); ?>"
						step="<?php echo esc_attr( $field['step'] ?? 1 ); ?>" value="<?php echo esc_attr( $value ); ?>" />
					<span class="mc-tool__slider-value" data-mc-slider-value><?php echo esc_html( $value ); ?><?php echo esc_html( $field['unit'] ?? '' ); ?></span>
					<?php
					break;

				default: // number
					?>
					<input class="mc-tool__number" type="number" id="mc-field-<?php echo $id; ?>" name="<?php echo esc_attr( $name ); ?>"
						min="<?php echo esc_attr( $field['min'] ?? '' ); ?>" max="<?php echo esc_attr( $field['max'] ?? '' ); ?>"
						step="<?php echo esc_attr( $field['step'] ?? 1 ); ?>" value="<?php echo esc_attr( $value ); ?>" />
					<?php
					break;
			}
			?>
		</div>
		<?php
	}

	private static function format( float $value, string $format ): string {
		switch ( $format ) {
			case 'currency':
				return number_format_i18n( $value, 2 ) . ' €';
			case 'percent':
				return number_format_i18n( $value, 2 ) . ' %';
			case 'duration_years':
				return number_format_i18n( $value / 12, 1 ) . ' ans';
			default:
				return (string) number_format_i18n( $value, 2 );
		}
	}
}

/**
 * Point d'entrée public pour les templates du thème.
 */
function mc_tools_render( string $slug, array $args = array() ): string {
	return MC_Tools_Renderer::render( $slug, $args );
}
