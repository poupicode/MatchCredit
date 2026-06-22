<section class="section-formulaire">
	<div class="container formulaire-grid">
		<div class="section-intro section-intro--formulaire">
			<p><?php the_field( 'contact_formulaire_intro' ); ?></p>
		</div>

		<div class="formulaire-card">
			<?php
			$cf7_shortcode = get_field( 'contact_form_cf7' );
			if ( $cf7_shortcode ) {
				echo do_shortcode( $cf7_shortcode );
			} else {
				echo '<p class="sub">Formulaire Contact Form 7 à venir — coller le shortcode dans le champ ACF « Formulaire de RDV ». Prévoir 3 étapes : coordonnées (civilité, nom, prénom, téléphone, email) → projet (type de projet) → disponibilités.</p>';
			}
			?>
		</div>
	</div>
</section>
