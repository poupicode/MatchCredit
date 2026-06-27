<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$haut_template      = 'page-reglages-header.php';
$haut_telephone     = matchcredit_reglages( 'haut_telephone', $haut_template );
$haut_telephone_tel = preg_replace( '/[^0-9+]/', '', (string) $haut_telephone );
?>

<div class="ticker">
	<div class="container ticker-row">
		<div class="ticker-group">
			<span class="ticker-item"><span class="dot"></span><?php echo esc_html( matchcredit_reglages( 'haut_texte_annonce', $haut_template ) ); ?></span>
			<span class="ticker-item ticker-item--muted"><?php echo esc_html( matchcredit_reglages( 'haut_ville', $haut_template ) ); ?></span>
		</div>
		<div class="ticker-group">
			<span class="ticker-item ticker-item--muted"><?php echo esc_html( matchcredit_reglages( 'haut_horaires', $haut_template ) ); ?></span>
			<a href="tel:<?php echo esc_attr( $haut_telephone_tel ); ?>" class="ticker-item ticker-item--phone"><?php echo esc_html( $haut_telephone ); ?></a>
		</div>
	</div>
</div>

<header class="nav">
	<div class="container nav-inner">
		<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="mc-dot"></span>matchcrédit</a>

		<button class="nav-burger" type="button" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="nav-mobile">
			<span></span><span></span><span></span>
		</button>

		<div class="nav-collapse" id="nav-mobile">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav-menu', 'fallback_cb' => false ) ); ?>
		</div>
	</div>
</header>
