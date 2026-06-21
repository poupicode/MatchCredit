<section class="section-agences">
	<div class="container">
		<div class="section-intro section-intro--agence">
			<h2 class="section-h"><?php matchcredit_title( 'agence_titre' ); ?></h2>
			<p><?php the_field( 'agence_texte_intro' ); ?></p>
		</div>

		<?php
		$agences = get_posts( array(
			'post_type'      => 'agence',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
		) );
		?>

		<?php if ( $agences ) : ?>
			<div class="agences-edit">
				<?php foreach ( $agences as $agence_post ) : ?>
					<div class="agence-edit">
						<?php $photo = get_field( 'photo', $agence_post->ID ); ?>
						<?php if ( $photo ) : ?>
							<img src="<?php echo esc_url( $photo ); ?>" alt="<?php echo esc_attr( get_the_title( $agence_post ) ); ?>" class="agence-photo">
						<?php endif; ?>
						<h3><?php echo esc_html( get_the_title( $agence_post ) ); ?></h3>
						<div class="who"><?php echo esc_html( get_field( 'courtier', $agence_post->ID ) ); ?></div>
						<div class="info">
							<?php echo esc_html( get_field( 'adresse', $agence_post->ID ) ); ?><br>
							<?php echo esc_html( get_field( 'code_postal_ville', $agence_post->ID ) ); ?><br>
							<strong><?php echo esc_html( get_field( 'telephone', $agence_post->ID ) ); ?></strong><br>
							<?php echo esc_html( get_field( 'horaires', $agence_post->ID ) ); ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="agence-cta">
			<?php matchcredit_link( 'agence_bouton', 'btn-yellow', 14 ); ?>
		</div>
	</div>
</section>
