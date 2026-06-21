<section class="hero">
	<div class="container">
		<div class="hero-meta"><?php the_field( 'badge' ); ?></div>

		<div class="hero-grid">
			<div>
				<h1 class="compact"><?php matchcredit_title( 'titre' ); ?></h1>

				<div class="hero-content">
					<p class="hero-slogan"><?php echo nl2br( esc_html( get_field( 'slogan' ) ) ); ?></p>
					<div class="hero-description"><?php the_field( 'description' ); ?></div>

					<div class="cta-row">
						<?php matchcredit_link( 'bouton_principal', 'btn-yellow', 14 ); ?>
						<?php matchcredit_link( 'bouton_secondaire', 'btn-text' ); ?>
					</div>
				</div>
			</div>

			<div class="hero-rdv-card" id="rdv">
				<h3><?php the_field( 'carte_titre' ); ?></h3>
				<?php
				$cf7_shortcode = get_field( 'carte_cf7_shortcode' );
				if ( $cf7_shortcode ) {
					echo do_shortcode( $cf7_shortcode );
				} else {
					echo '<p class="sub">Formulaire Contact Form 7 à venir — coller le shortcode dans le champ ACF « Carte rappel — shortcode Contact Form 7 ».</p>';
				}
				?>
			</div>
		</div>
	</div>
</section>
