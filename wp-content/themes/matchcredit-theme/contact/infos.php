<?php
$agence = get_posts( array(
	'post_type'      => 'agence',
	'posts_per_page' => 1,
	'orderby'        => 'menu_order title',
	'order'          => 'ASC',
) );
$agence    = $agence ? $agence[0] : null;
$acces     = get_field( 'contact_acces' );
$maps_code = get_field( 'contact_maps_embed' );

if ( $maps_code && false === strpos( $maps_code, 'loading=' ) ) {
	$maps_code = preg_replace( '/<iframe /', '<iframe loading="lazy" ', $maps_code, 1 );
}

$maps_allowed_html = array(
	'iframe' => array(
		'src'             => true,
		'width'           => true,
		'height'          => true,
		'style'           => true,
		'allowfullscreen' => true,
		'loading'         => true,
		'referrerpolicy'  => true,
		'frameborder'     => true,
	),
);
?>
<section class="section-infos">
	<div class="container infos-grid">
		<div class="infos-texte">
			<h2 class="section-h section-h--sm"><?php the_field( 'contact_infos_titre' ); ?></h2>

			<?php if ( $agence ) : ?>
				<div class="infos-ligne">
					<?php echo esc_html( get_field( 'adresse', $agence->ID ) ); ?><br>
					<?php echo esc_html( get_field( 'code_postal_ville', $agence->ID ) ); ?>
				</div>
				<div class="infos-ligne">
					<strong><?php echo esc_html( get_field( 'telephone', $agence->ID ) ); ?></strong>
				</div>
				<div class="infos-ligne">
					<?php echo esc_html( get_field( 'horaires', $agence->ID ) ); ?>
				</div>
			<?php endif; ?>

			<?php if ( $acces ) : ?>
				<div class="infos-ligne infos-acces"><?php echo esc_html( $acces ); ?></div>
			<?php endif; ?>
		</div>

		<div class="infos-carte">
			<?php if ( $maps_code ) : ?>
				<?php echo wp_kses( $maps_code, $maps_allowed_html ); ?>
			<?php else : ?>
				<p class="sub">Carte Google Maps à venir — coller le code d'intégration (Google Maps → Partager → Intégrer une carte) dans le champ ACF « Carte Google Maps » de cette page.</p>
			<?php endif; ?>
		</div>
	</div>
</section>
