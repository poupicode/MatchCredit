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
				<div class="label"><?php the_field( 'carte_eyebrow' ); ?></div>
				<h3><?php matchcredit_title( 'carte_titre' ); ?></h3>
				<p class="sub"><?php the_field( 'carte_sous_titre' ); ?></p>
				<?php
				$cf7_shortcode = get_field( 'carte_cf7_shortcode' );
				if ( $cf7_shortcode ) {
					echo do_shortcode( $cf7_shortcode );
				} else {
					echo '<p class="sub">Formulaire Contact Form 7 à venir — coller le shortcode dans le champ ACF « Carte rappel — shortcode Contact Form 7 ».</p>';
				}
				?>
				<p class="legal-mini"><?php the_field( 'carte_legal' ); ?></p>
			</div>
		</div>
	</div>
</section>
