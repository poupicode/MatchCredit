<section class="page-section page-section--white">
	<div class="container">
		<div class="page-split-head">
			<div class="eyebrow"><?php the_field( 'rs_etapes_eyebrow' ); ?></div>
		</div>
		<div class="page-split">
			<div class="page-split-aside page-split-aside--sticky">
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'rs_etapes_titre' ); ?></h2>
			</div>

			<div class="page-split-content">
				<ul class="page-steps">
					<?php foreach ( array( 'rs_etape_1', 'rs_etape_2', 'rs_etape_3', 'rs_etape_4', 'rs_etape_5' ) as $etape_key ) :
						$etape = get_field( $etape_key );
						if ( ! $etape ) continue;
						?>
						<li class="page-step">
							<div>
								<h3><?php echo esc_html( $etape['titre'] ); ?></h3>
								<p><?php echo esc_html( $etape['texte'] ); ?></p>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>
