<section class="page-hero page-hero--article">
	<div class="container">
		<div class="page-breadcrumb">
			<a href="<?php echo esc_url( home_url( '/credit-immobilier/' ) ); ?>">Crédit immobilier</a>
			<span class="sep">/</span>
			<span class="is-current"><?php the_field( 'fg_hero_eyebrow' ); ?></span>
		</div>
		<h1 class="section-h page-hero-title"><?php matchcredit_title( 'fg_hero_titre' ); ?></h1>
		<p class="page-hero-subtitle"><?php the_field( 'fg_hero_soustitre' ); ?></p>
		<?php matchcredit_link( 'fg_hero_bouton', 'btn-yellow', 14 ); ?>
	</div>
</section>
