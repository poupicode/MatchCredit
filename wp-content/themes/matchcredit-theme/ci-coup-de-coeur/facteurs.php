<section class="page-section page-section--white">
	<div class="container">
		<div class="section-intro">
			<div class="eyebrow"><?php the_field( 'cdc_facteurs_eyebrow' ); ?></div>
			<h2 class="section-h section-h--sm"><?php matchcredit_title( 'cdc_facteurs_titre' ); ?></h2>
		</div>

		<div class="tools-edit-grid">
			<?php foreach ( array( 'cdc_facteur_1', 'cdc_facteur_2', 'cdc_facteur_3' ) as $i => $facteur_key ) :
				$facteur = get_field( $facteur_key );
				if ( ! $facteur ) continue;
				?>
				<div class="tool-edit-card">
					<div class="card-num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></div>
					<h3><?php echo esc_html( $facteur['titre'] ); ?></h3>
					<p><?php echo esc_html( $facteur['texte'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
