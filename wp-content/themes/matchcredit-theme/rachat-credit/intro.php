<section class="page-section page-section--white">
	<div class="container">
		<div class="page-split-head">
			<div class="eyebrow"><?php the_field( 'rc_intro_eyebrow' ); ?></div>
		</div>
		<div class="page-split">
			<div class="page-split-aside">
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'rc_intro_titre' ); ?></h2>
			</div>
			<div class="page-split-content">
				<div class="section-intro">
					<?php the_field( 'rc_intro_texte_1' ); ?>
				</div>
				<div class="section-intro">
					<?php the_field( 'rc_intro_texte_2' ); ?>
				</div>
			</div>
		</div>
	</div>
</section>
