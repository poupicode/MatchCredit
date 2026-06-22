<?php
$lexique_page = get_posts( array(
	'post_type'      => 'page',
	'post_status'    => 'publish',
	'meta_key'       => '_wp_page_template',
	'meta_value'     => 'page-lexique.php',
	'posts_per_page' => 1,
	'fields'         => 'ids',
) );
$lexique_url = $lexique_page ? get_permalink( $lexique_page[0] ) : '';
?>
<section class="section-metier">
	<div class="container metier-content">
		<h2 class="section-h section-h--sm"><?php the_field( 'contact_metier_titre' ); ?></h2>
		<?php echo wp_kses_post( get_field( 'contact_metier_texte' ) ); ?>
		<?php if ( $lexique_url ) : ?>
			<p><a href="<?php echo esc_url( $lexique_url ); ?>">Voir aussi la définition dans notre lexique</a>.</p>
		<?php endif; ?>
	</div>
</section>
