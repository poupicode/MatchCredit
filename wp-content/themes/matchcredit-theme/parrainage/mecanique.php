<section class="page-section page-section--white">
	<div class="container">
		<div class="section-intro section-intro--center">
			<div class="eyebrow"><?php the_field( 'parr_mecanique_eyebrow' ); ?></div>
			<h2 class="section-h section-h--sm"><?php matchcredit_title( 'parr_mecanique_titre' ); ?></h2>
		</div>

		<div class="page-grid-2">
			<ul class="page-steps">
				<?php foreach ( array( 'parr_etape_1', 'parr_etape_2', 'parr_etape_3' ) as $etape_key ) :
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

			<div class="amount-block">
				<div class="lbl"><?php the_field( 'parr_montant_label' ); ?></div>
				<div class="num"><?php the_field( 'parr_montant' ); ?></div>
				<div class="sub"><?php the_field( 'parr_montant_mention' ); ?></div>
				<div class="conditions"><?php the_field( 'parr_montant_legale' ); ?></div>
			</div>
		</div>
	</div>
</section>
