<?php
// CTA partagé par les pages "Rachat de crédit" et ses sous-pages — réglages centralisés
// sur la page modèle "page-reglages-cta.php" (pas d'options page en ACF Free, voir matchcredit_reglages()).
$cta_post_id = matchcredit_reglages_post_id( 'page-reglages-cta.php' );
?>
<section class="cta-final" id="contact-final">
	<div class="cta-shape"></div>
	<div class="container">
		<h2><?php matchcredit_title( 'cta_titre', $cta_post_id ); ?></h2>
		<p class="cta-final-text"><?php the_field( 'cta_texte', $cta_post_id ); ?></p>
		<div class="cta-final-row">
			<?php matchcredit_link( 'cta_bouton', 'btn-dark', 16, $cta_post_id ); ?>
			<div class="cta-final-meta">
				<strong><?php the_field( 'cta_telephone', $cta_post_id ); ?></strong>
				<span><?php the_field( 'cta_horaires', $cta_post_id ); ?></span>
			</div>
		</div>
	</div>
</section>
