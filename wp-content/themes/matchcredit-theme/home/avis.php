<section class="section-avis">
	<div class="container">
		<div class="section-intro section-intro--avis">
			<h2 class="section-h"><?php matchcredit_title( 'avis_titre' ); ?></h2>
			<p><?php the_field( 'avis_sous_titre' ); ?></p>
		</div>

		<?php
		$avis_list = get_posts( array(
			'post_type'      => 'avis',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order date',
			'order'          => 'DESC',
		) );
		?>

		<?php if ( $avis_list ) : ?>
			<div class="avis-grid">
				<?php foreach ( $avis_list as $avis_post ) :
					$nom   = get_field( 'nom', $avis_post->ID );
					$texte = get_field( 'texte', $avis_post->ID );
					$note  = (int) get_field( 'note', $avis_post->ID );
					?>
					<div class="avis-card">
						<div class="avis-note">
							<?php for ( $i = 1; $i <= 5; $i++ ) {
								echo $i <= $note ? '★' : '☆';
							} ?>
						</div>
						<p class="avis-texte">« <?php echo esc_html( $texte ); ?> »</p>
						<div class="avis-nom"><?php echo esc_html( $nom ?: get_the_title( $avis_post ) ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
