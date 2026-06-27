<section class="page-section page-section--white">
	<div class="container">
		<div class="page-split-head">
			<div class="eyebrow"><?php the_field( 'cdc_financer_eyebrow' ); ?></div>
		</div>
		<div class="page-split">
			<div class="page-split-aside">
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'cdc_financer_titre' ); ?></h2>
			</div>
			<div class="page-split-content">
				<div class="section-intro">
					<?php the_field( 'cdc_financer_texte' ); ?>
				</div>
				<ul class="page-list">
					<?php
					$cdc_financer_liste = explode( "\n", (string) get_field( 'cdc_financer_liste' ) );
					foreach ( $cdc_financer_liste as $item ) :
						$item = trim( $item );
						if ( ! $item ) continue;
						?>
						<li><?php echo esc_html( $item ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>
