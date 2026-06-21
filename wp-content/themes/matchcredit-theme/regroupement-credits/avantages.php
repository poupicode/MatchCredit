<section class="page-section page-section--cream">
	<div class="container">
		<div class="page-split-head">
			<div class="eyebrow"><?php the_field( 'rg_avantages_eyebrow' ); ?></div>
		</div>
		<div class="page-split">
			<div class="page-split-aside page-split-aside--sticky">
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'rg_avantages_titre' ); ?></h2>
			</div>

			<div class="page-split-content">
				<ul class="page-list">
					<?php
					$rg_avantages_liste = explode( "\n", (string) get_field( 'rg_avantages_liste' ) );
					foreach ( $rg_avantages_liste as $avantage ) :
						$avantage = trim( $avantage );
						if ( ! $avantage ) continue;
						?>
						<li><?php echo esc_html( $avantage ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>
