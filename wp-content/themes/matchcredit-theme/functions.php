<?php

function matchcredit_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption' ) );

	register_nav_menus( array(
		'primary' => __( 'Menu principal', 'matchcredit' ),
		'footer'  => __( 'Menu pied de page', 'matchcredit' ),
	) );
}
add_action( 'after_setup_theme', 'matchcredit_setup' );

/**
 * CPT Agence — une agence MatchCrédit (ville, courtier, coordonnées...).
 */
function matchcredit_register_cpt_agence() {
	register_post_type( 'agence', array(
		'label'        => __( 'Agences', 'matchcredit' ),
		'labels'       => array(
			'name'          => __( 'Agences', 'matchcredit' ),
			'singular_name' => __( 'Agence', 'matchcredit' ),
			'add_new_item'  => __( 'Ajouter une agence', 'matchcredit' ),
			'edit_item'     => __( 'Modifier l\'agence', 'matchcredit' ),
		),
		'public'       => true,
		'has_archive'  => false,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-store',
		'supports'     => array( 'title' ),
		'rewrite'      => array( 'slug' => 'agence' ),
	) );
}
add_action( 'init', 'matchcredit_register_cpt_agence' );

/**
 * CPT Avis — un témoignage client (nom, texte, note).
 */
function matchcredit_register_cpt_avis() {
	register_post_type( 'avis', array(
		'label'        => __( 'Avis', 'matchcredit' ),
		'labels'       => array(
			'name'          => __( 'Avis', 'matchcredit' ),
			'singular_name' => __( 'Avis', 'matchcredit' ),
			'add_new_item'  => __( 'Ajouter un avis', 'matchcredit' ),
			'edit_item'     => __( 'Modifier l\'avis', 'matchcredit' ),
		),
		'public'       => true,
		'has_archive'  => false,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-format-quote',
		'supports'     => array( 'title' ),
		'rewrite'      => array( 'slug' => 'avis' ),
	) );
}
add_action( 'init', 'matchcredit_register_cpt_avis' );

function matchcredit_enqueue_fonts() {
	wp_enqueue_style(
		'matchcredit-fonts',
		'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600&family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;1,9..144,300;1,9..144,400&family=JetBrains+Mono:wght@400;500&display=swap',
		array(),
		null
	);
}
add_action( 'wp_enqueue_scripts', 'matchcredit_enqueue_fonts' );

function matchcredit_enqueue_assets() {
	$css_path = get_template_directory() . '/assets/css/main.css';
	$js_path  = get_template_directory() . '/assets/js/main.js';

	if ( file_exists( $css_path ) ) {
		wp_enqueue_style( 'matchcredit-main', get_template_directory_uri() . '/assets/css/main.css', array(), filemtime( $css_path ) );
	}

	if ( file_exists( $js_path ) ) {
		wp_enqueue_script( 'matchcredit-main', get_template_directory_uri() . '/assets/js/main.js', array(), filemtime( $js_path ), true );
	}
}
add_action( 'wp_enqueue_scripts', 'matchcredit_enqueue_assets' );

/**
 * "Pages réglages" — ACF Free n'a pas de vraie page d'options (Pro uniquement).
 * À la place : deux pages WordPress dédiées (non publiées, jamais dans un menu),
 * chacune avec un modèle de page propre (page-reglages-*.php). Les groupes de
 * champs ACF sont localisés sur ce modèle. On retrouve l'ID de la page par son
 * modèle plutôt qu'un ID en dur, pour rester portable entre environnements.
 */
function matchcredit_reglages_post_id( $template ) {
	static $cache = array();

	if ( isset( $cache[ $template ] ) ) {
		return $cache[ $template ];
	}

	$pages = get_posts( array(
		'post_type'      => 'page',
		'post_status'    => 'any',
		'meta_key'       => '_wp_page_template',
		'meta_value'     => $template,
		'posts_per_page' => 1,
		'fields'         => 'ids',
	) );

	$cache[ $template ] = $pages ? (int) $pages[0] : 0;

	return $cache[ $template ];
}

function matchcredit_reglages( $field_name, $template ) {
	$post_id = matchcredit_reglages_post_id( $template );

	return $post_id ? get_field( $field_name, $post_id ) : null;
}

/**
 * Dossier de synchronisation des groupes de champs ACF.
 */
add_filter( 'acf/settings/save_json', function () {
	return get_template_directory() . '/acf-json';
} );

add_filter( 'acf/settings/load_json', function ( $paths ) {
	$paths[] = get_template_directory() . '/acf-json';
	return $paths;
} );

/**
 * Icône flèche SVG, réutilisée dans plusieurs sections (boutons, liens).
 */
function matchcredit_icon_arrow( $size = 14 ) {
	printf(
		'<svg width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"></path></svg>',
		(int) $size
	);
}

/**
 * Affiche un champ ACF de type "lien" sous forme de balise <a>.
 */
function matchcredit_link( $field_name, $class = '', $arrow_size = 0, $post_id = false ) {
	$link = get_field( $field_name, $post_id );

	if ( ! $link || empty( $link['url'] ) ) {
		return;
	}

	$target = ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '';
	$arrow  = '';

	if ( $arrow_size ) {
		ob_start();
		matchcredit_icon_arrow( $arrow_size );
		$arrow = '<span class="arrow">' . ob_get_clean() . '</span>';
	}

	printf(
		'<a href="%1$s" class="%2$s"%3$s>%4$s%5$s</a>',
		esc_url( $link['url'] ),
		esc_attr( $class ),
		$target,
		esc_html( $link['title'] ),
		$arrow
	);
}

/**
 * Retire le(s) <p> qu'un champ ACF wysiwyg ajoute automatiquement autour d'un titre
 * (un <p> dans un <h1>/<h2>/<h3> est invalide en HTML et complique le CSS), en gardant
 * les balises inline (em, strong, span, br). Un saut de paragraphe devient un <br>.
 */
function matchcredit_strip_title_p( $html ) {
	if ( ! $html ) {
		return '';
	}

	$html = preg_replace( '#^\s*<p[^>]*>\s*|\s*</p>\s*$#i', '', trim( $html ) );
	$html = preg_replace( '#</p>\s*<p[^>]*>#i', '<br>', $html );

	return wp_kses_post( $html );
}

/**
 * Affiche un champ ACF wysiwyg utilisé comme titre, sans le <p> englobant.
 */
function matchcredit_title( $field_name, $post_id = false ) {
	echo matchcredit_strip_title_p( get_field( $field_name, $post_id ) );
}

/**
 * Charge un fichier de section depuis /{folder}/{slug}.php (folder = page : home, etc.)
 */
function matchcredit_section( $slug, $folder = 'home', $args = array() ) {
	$path = get_template_directory() . '/' . $folder . '/' . $slug . '.php';

	if ( file_exists( $path ) ) {
		load_template( $path, false, $args );
	}
}
