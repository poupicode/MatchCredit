<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Écran d'édition custom pour mc_tool : remplace le besoin de bidouiller du
 * JSON à la main par une mini app React (cf. cadrage section 9).
 */
class MC_Tools_Admin {

	public static function init() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue' ) );
		add_action( 'edit_form_after_title', array( __CLASS__, 'render_root' ) );
	}

	public static function enqueue( string $hook ) {
		if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
			return;
		}

		global $post;
		if ( ! $post || MC_Tools_CPT::POST_TYPE !== $post->post_type ) {
			return;
		}

		$asset_file = MC_TOOLS_PATH . 'admin/dist/builder.asset.php';
		$asset      = file_exists( $asset_file ) ? require $asset_file : array( 'dependencies' => array(), 'version' => MC_TOOLS_VERSION );

		wp_enqueue_script(
			'mc-tools-builder',
			MC_TOOLS_URL . 'admin/dist/builder.js',
			$asset['dependencies'],
			$asset['version'],
			true
		);
		wp_enqueue_style( 'mc-tools-builder', MC_TOOLS_URL . 'admin/dist/style-builder.css', array(), $asset['version'] );

		wp_localize_script(
			'mc-tools-builder',
			'mcToolsBuilder',
			array(
				'postId'  => $post->ID,
				'restUrl' => esc_url_raw( rest_url( 'matchcredit/v1/' ) ),
				'nonce'   => wp_create_nonce( 'wp_rest' ),
			)
		);
	}

	public static function render_root( WP_Post $post ) {
		if ( MC_Tools_CPT::POST_TYPE !== $post->post_type ) {
			return;
		}
		echo '<div id="mc-tools-builder-root"></div>';
	}
}
