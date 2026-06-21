<?php
/**
 * Plugin Name: MatchCrédit Tools
 * Description: Moteur générique de calculettes et simulations de crédit, configurables sans code.
 * Version: 0.1.0
 * Author: poupicode
 * Text Domain: matchcredit-tools
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MC_TOOLS_VERSION', '0.1.0' );
define( 'MC_TOOLS_PATH', plugin_dir_path( __FILE__ ) );
define( 'MC_TOOLS_URL', plugin_dir_url( __FILE__ ) );

require_once MC_TOOLS_PATH . 'includes/class-formula-parser.php';
require_once MC_TOOLS_PATH . 'includes/class-presets.php';
require_once MC_TOOLS_PATH . 'includes/class-cpt.php';
require_once MC_TOOLS_PATH . 'includes/class-renderer.php';
require_once MC_TOOLS_PATH . 'includes/class-shortcode.php';
require_once MC_TOOLS_PATH . 'includes/class-rest-api.php';
require_once MC_TOOLS_PATH . 'includes/class-admin.php';

MC_Tools_CPT::init();
MC_Tools_Shortcode::init();
MC_Tools_Rest_Api::init();
MC_Tools_Admin::init();

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_register_style( 'mc-tools-widget', MC_TOOLS_URL . 'public/css/tool-widget.css', array(), MC_TOOLS_VERSION );
		wp_register_script( 'mc-tools-widget', MC_TOOLS_URL . 'public/js/tool-widget.js', array(), MC_TOOLS_VERSION, true );
		wp_localize_script(
			'mc-tools-widget',
			'mcToolsSettings',
			array(
				'restUrl' => esc_url_raw( rest_url( 'matchcredit/v1/' ) ),
			)
		);
	}
);
