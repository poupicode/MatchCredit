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

/**
 * CPT Membre d'équipe — une fiche conseiller (photo, rôle, lien de RDV).
 * Pas de repeater (ACF Free) : chaque membre est publié/dépublié indépendamment.
 */
function matchcredit_register_cpt_membre_equipe() {
	register_post_type( 'membre_equipe', array(
		'label'        => __( 'Membres équipe', 'matchcredit' ),
		'labels'       => array(
			'name'          => __( 'Membres équipe', 'matchcredit' ),
			'singular_name' => __( 'Membre équipe', 'matchcredit' ),
			'add_new_item'  => __( 'Ajouter un membre', 'matchcredit' ),
			'edit_item'     => __( 'Modifier le membre', 'matchcredit' ),
		),
		'public'       => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-groups',
		'supports'     => array( 'title' ),
		'has_archive'  => false,
	) );
}
add_action( 'init', 'matchcredit_register_cpt_membre_equipe' );

/**
 * CPT Terme de lexique — une entrée du glossaire (terme + définition + lettre).
 */
function matchcredit_register_cpt_lexique_terme() {
	register_post_type( 'lexique_terme', array(
		'label'        => __( 'Termes de lexique', 'matchcredit' ),
		'labels'       => array(
			'name'          => __( 'Termes de lexique', 'matchcredit' ),
			'singular_name' => __( 'Terme de lexique', 'matchcredit' ),
			'add_new_item'  => __( 'Ajouter un terme', 'matchcredit' ),
			'edit_item'     => __( 'Modifier le terme', 'matchcredit' ),
		),
		'public'       => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-book-alt',
		'supports'     => array( 'title' ),
		'has_archive'  => false,
	) );
}
add_action( 'init', 'matchcredit_register_cpt_lexique_terme' );

/**
 * Import unique des termes du lexique depuis data/lexique-matchcredit.json.
 * Bouton dans l'écran d'admin du CPT — idempotent (skip par titre déjà existant).
 */
function matchcredit_lexique_import_notice() {
	$screen = get_current_screen();

	if ( ! $screen || 'edit-lexique_terme' !== $screen->id ) {
		return;
	}

	if ( isset( $_GET['matchcredit_lexique_imported'] ) ) {
		printf( '<div class="notice notice-success"><p>%s</p></div>', esc_html__( 'Import du lexique terminé.', 'matchcredit' ) );
		return;
	}

	$url = wp_nonce_url( admin_url( 'edit.php?post_type=lexique_terme&matchcredit_lexique_import=1' ), 'matchcredit_lexique_import' );
	printf(
		'<div class="notice notice-info"><p>%s <a href="%s" class="button">%s</a></p></div>',
		esc_html__( 'Importer les termes depuis data/lexique-matchcredit.json :', 'matchcredit' ),
		esc_url( $url ),
		esc_html__( 'Importer le lexique', 'matchcredit' )
	);
}
add_action( 'admin_notices', 'matchcredit_lexique_import_notice' );

function matchcredit_lexique_handle_import() {
	if ( empty( $_GET['matchcredit_lexique_import'] ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	check_admin_referer( 'matchcredit_lexique_import' );

	$path = get_template_directory() . '/data/lexique-matchcredit.json';

	if ( ! file_exists( $path ) ) {
		wp_die( esc_html__( 'Fichier lexique-matchcredit.json introuvable.', 'matchcredit' ) );
	}

	$entries = json_decode( file_get_contents( $path ), true );

	if ( ! is_array( $entries ) ) {
		wp_die( esc_html__( 'Fichier JSON invalide.', 'matchcredit' ) );
	}

	foreach ( $entries as $entry ) {
		$existing = get_page_by_title( $entry['terme'], OBJECT, 'lexique_terme' );

		if ( $existing ) {
			continue;
		}

		$post_id = wp_insert_post( array(
			'post_type'   => 'lexique_terme',
			'post_title'  => $entry['terme'],
			'post_status' => 'publish',
		) );

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}

		update_field( 'lettre', $entry['lettre'], $post_id );
		update_field( 'definition', $entry['definition'], $post_id );

		if ( ! empty( $entry['lien_interne'] ) ) {
			update_field( 'lien_interne', $entry['lien_interne'], $post_id );
		}
	}

	wp_safe_redirect( admin_url( 'edit.php?post_type=lexique_terme&matchcredit_lexique_imported=1' ) );
	exit;
}
add_action( 'admin_init', 'matchcredit_lexique_handle_import' );

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
