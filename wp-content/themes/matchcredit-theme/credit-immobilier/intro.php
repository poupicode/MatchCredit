<section class="page-section page-section--white">
	<div class="container">
		<div class="page-split-head">
			<div class="eyebrow"><?php the_field( 'cri_intro_eyebrow' ); ?></div>
		</div>
		<div class="page-split">
			<div class="page-split-aside">
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'cri_intro_titre' ); ?></h2>
			</div>
			<div class="page-split-content">
				<div class="section-intro">
					<?php the_field( 'cri_intro_texte' ); ?>
				</div>
				<p class="page-note"><strong><?php the_field( 'cri_intro_note_label' ); ?></strong> <?php the_field( 'cri_intro_note_texte' ); ?></p>
			</div>
		</div>
	</div>
</section>
