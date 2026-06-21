<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MC_Tools_CPT {

	const POST_TYPE = 'mc_tool';

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register' ) );
	}

	public static function register() {
		register_post_type(
			self::POST_TYPE,
			array(
				'labels'       => array(
					'name'          => __( 'Calculettes & Simulations', 'matchcredit-tools' ),
					'singular_name' => __( 'Calculette / Simulation', 'matchcredit-tools' ),
					'add_new_item'  => __( 'Ajouter une calculette', 'matchcredit-tools' ),
					'edit_item'     => __( 'Modifier la calculette', 'matchcredit-tools' ),
				),
				'public'       => false,
				'show_ui'      => true,
				'show_in_menu' => true,
				'menu_icon'    => 'dashicons-calculator',
				'supports'     => array( 'title' ),
				'has_archive'  => false,
				'rewrite'      => array( 'slug' => 'calculette' ),
				'show_in_rest' => true,
			)
		);
	}
}
