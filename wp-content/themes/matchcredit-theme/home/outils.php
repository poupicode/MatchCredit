<section class="section-outils">
	<div class="container">
		<div class="section-intro">
			<div class="eyebrow"><?php the_field( 'outils_etiquette' ); ?></div>
			<h2 class="section-h section-h--sm"><?php matchcredit_title( 'outils_titre' ); ?></h2>
		</div>

		<div class="tools-edit-grid">
			<div class="tool-edit-card">
				<span class="label-tag"><?php the_field( 'carte_1_badge' ); ?></span>
				<h3><?php matchcredit_title( 'carte_1_titre' ); ?></h3>
				<p><?php the_field( 'carte_1_texte' ); ?></p>
				<?php matchcredit_link( 'carte_1_lien', 'tool-cta', 14 ); ?>
			</div>

			<div class="tool-edit-card">
				<span class="label-tag"><?php the_field( 'carte_2_badge' ); ?></span>
				<h3><?php matchcredit_title( 'carte_2_titre' ); ?></h3>
				<p><?php the_field( 'carte_2_texte' ); ?></p>
				<?php matchcredit_link( 'carte_2_lien', 'tool-cta', 14 ); ?>
			</div>

			<div class="tool-edit-card">
				<span class="label-tag"><?php the_field( 'carte_3_badge' ); ?></span>
				<h3><?php matchcredit_title( 'carte_3_titre' ); ?></h3>
				<p><?php the_field( 'carte_3_texte' ); ?></p>
				<?php matchcredit_link( 'carte_3_lien', 'tool-cta', 14 ); ?>
			</div>
		</div>
	</div>
</section>
