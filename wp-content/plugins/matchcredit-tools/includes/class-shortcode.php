<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MC_Tools_Shortcode {

	public static function init() {
		add_shortcode( 'mc_tool', array( __CLASS__, 'render' ) );
	}

	/** @param array<string,string> $atts */
	public static function render( $atts ): string {
		$atts = shortcode_atts( array( 'id' => '' ), $atts, 'mc_tool' );

		if ( '' === $atts['id'] ) {
			return '';
		}

		return mc_tools_render( sanitize_title( $atts['id'] ) );
	}
}
