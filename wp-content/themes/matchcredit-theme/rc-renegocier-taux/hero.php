<section class="page-hero page-hero--article">
	<div class="container">
		<div class="page-breadcrumb">
			<a href="<?php echo esc_url( home_url( '/rachat-credit/' ) ); ?>">Rachat de crédit</a>
			<span class="sep">/</span>
			<span class="is-current"><?php the_field( 'rrt_hero_eyebrow' ); ?></span>
		</div>
		<h1 class="section-h page-hero-title"><?php matchcredit_title( 'rrt_hero_titre' ); ?></h1>
		<p class="page-hero-subtitle"><?php the_field( 'rrt_hero_soustitre' ); ?></p>
		<?php matchcredit_link( 'rrt_hero_bouton', 'btn-yellow', 14 ); ?>
	</div>
</section>
