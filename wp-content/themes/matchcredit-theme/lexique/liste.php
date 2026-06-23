<?php
/**
 * Liste du lexique, groupée par lettre, avec barre A-Z et colonne sticky.
 */

$lexique_query = new WP_Query( array(
	'post_type'      => 'lexique_terme',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'orderby'        => 'title',
	'order'          => 'ASC',
) );

$groups = array();

foreach ( $lexique_query->posts as $post ) {
	$lettre = strtoupper( get_field( 'lettre', $post->ID ) ?: mb_substr( $post->post_title, 0, 1 ) );

	if ( ! isset( $groups[ $lettre ] ) ) {
		$groups[ $lettre ] = array();
	}

	$groups[ $lettre ][] = $post;
}

ksort( $groups );

if ( empty( $groups ) ) {
	return;
}
?>

<section class="lexique-liste">
	<nav class="lexique-az-bar" aria-label="Aller à la lettre">
		<ul class="lexique-az-bar-list">
			<?php foreach ( array_keys( $groups ) as $lettre ) : ?>
				<li><a href="#lettre-<?php echo esc_attr( $lettre ); ?>" data-letter="<?php echo esc_attr( $lettre ); ?>"><?php echo esc_html( $lettre ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</nav>

	<div class="container">
		<div class="lexique-layout">
			<?php foreach ( $groups as $lettre => $terms ) : ?>
				<div class="lexique-row-letter" id="lettre-<?php echo esc_attr( $lettre ); ?>" data-letter="<?php echo esc_attr( $lettre ); ?>">
					<?php echo esc_html( $lettre ); ?>
				</div>

				<div class="lexique-row-content">
					<dl class="lexique-terms">
						<?php foreach ( $terms as $term_post ) : ?>
							<div class="lexique-term">
								<dt><?php echo esc_html( $term_post->post_title ); ?></dt>
								<dd>
									<?php echo wp_kses_post( get_field( 'definition', $term_post->ID ) ); ?>
									<?php $lien = get_field( 'lien_interne', $term_post->ID ); ?>
									<?php if ( $lien ) : ?>
										<a class="lexique-term-link" href="<?php echo esc_url( $lien ); ?>">En savoir plus <?php matchcredit_icon_arrow( 12 ); ?></a>
									<?php endif; ?>
								</dd>
							</div>
						<?php endforeach; ?>
					</dl>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
