<section class="page-section page-section--cream" id="parrainage-form">
	<div class="container">
		<div class="section-intro section-intro--center">
			<h2 class="section-h section-h--sm"><?php matchcredit_title( 'parr_form_titre' ); ?></h2>
			<p><?php the_field( 'parr_form_texte' ); ?></p>
		</div>

		<div class="formulaire-card formulaire-card--center">
			<?php
			$cf7_shortcode = get_field( 'parr_form_cf7' );
			if ( $cf7_shortcode ) {
				echo do_shortcode( $cf7_shortcode );
			} else {
				echo '<p class="sub">Formulaire Contact Form 7 à venir — coller le shortcode dans le champ ACF « Formulaire — shortcode CF7 ». Prévoir : vos coordonnées (nom, prénom, email, téléphone), coordonnées du filleul (nom, prénom, téléphone), et votre numéro de dossier client si vous en avez déjà un.</p>';
			}
			?>
		</div>
	</div>
</section>
