<section class="page-hero page-hero--article">
	<div class="container">
		<div class="eyebrow"><?php the_field( 'parr_hero_eyebrow' ); ?></div>
		<h1 class="section-h page-hero-title"><?php matchcredit_title( 'parr_hero_titre' ); ?></h1>
		<p class="page-hero-subtitle"><?php the_field( 'parr_hero_soustitre' ); ?></p>
		<?php matchcredit_link( 'parr_hero_bouton', 'btn-yellow', 14 ); ?>
	</div>
</section>
