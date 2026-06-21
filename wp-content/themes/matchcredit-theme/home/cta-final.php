<section class="cta-final" id="contact-final">
	<div class="cta-shape"></div>
	<div class="container">
		<h2><?php matchcredit_title( 'cta_titre' ); ?></h2>
		<p class="cta-final-text"><?php the_field( 'cta_texte' ); ?></p>
		<div class="cta-final-row">
			<?php matchcredit_link( 'cta_bouton', 'btn-dark', 16 ); ?>
			<div class="cta-final-meta">
				<strong><?php the_field( 'cta_telephone' ); ?></strong>
				<span><?php the_field( 'cta_horaires' ); ?></span>
			</div>
		</div>
	</div>
</section>
