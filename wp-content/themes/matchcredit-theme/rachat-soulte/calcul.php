<section class="page-section page-section--white">
	<div class="container">
		<div class="page-split-head">
			<div class="eyebrow"><?php the_field( 'rs_calcul_eyebrow' ); ?></div>
		</div>
		<div class="page-split">
			<div class="page-split-aside page-split-aside--sticky">
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'rs_calcul_titre' ); ?></h2>
			</div>

			<div class="page-split-content">
				<ul class="page-list">
					<?php
					$rs_calcul_liste = explode( "\n", (string) get_field( 'rs_calcul_liste' ) );
					foreach ( $rs_calcul_liste as $item ) :
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
