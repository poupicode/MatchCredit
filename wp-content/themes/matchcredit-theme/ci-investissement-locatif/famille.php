<section class="page-section page-section--cream">
	<div class="container">
		<div class="page-split-head">
			<div class="eyebrow"><?php the_field( 'il_famille_eyebrow' ); ?></div>
		</div>
		<div class="page-split">
			<div class="page-split-aside">
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'il_famille_titre' ); ?></h2>
			</div>
			<div class="page-split-content">
				<div class="section-intro">
					<?php the_field( 'il_famille_texte' ); ?>
				</div>
				<ul class="page-list">
					<?php
					$il_famille_conditions = explode( "\n", (string) get_field( 'il_famille_conditions' ) );
					foreach ( $il_famille_conditions as $condition ) :
						$condition = trim( $condition );
						if ( ! $condition ) continue;
						?>
						<li><?php echo esc_html( $condition ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>
