<section class="page-hero">
	<div class="container">
		<div class="hero-grid">
			<div>
				<div class="eyebrow"><?php the_field( 'rs_hero_eyebrow' ); ?></div>
				<h1 class="section-h page-hero-title"><?php matchcredit_title( 'rs_hero_titre' ); ?></h1>
				<p class="page-hero-subtitle"><?php the_field( 'rs_hero_soustitre' ); ?></p>
				<?php matchcredit_link( 'rs_hero_bouton', 'btn-yellow', 14 ); ?>
			</div>

			<div class="hero-rdv-card" id="rdv">
				<div class="label">Rachat de soulte</div>
				<h3><?php the_field( 'rs_hero_carte_titre' ); ?></h3>
				<?php
				$cf7_shortcode = get_field( 'rs_hero_carte_cf7' );
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
