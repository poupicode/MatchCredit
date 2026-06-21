<section class="page-section page-section--white">
	<div class="container">
		<div class="section-intro">
			<div class="eyebrow"><?php the_field( 'rg_integre_eyebrow' ); ?></div>
			<h2 class="section-h section-h--sm"><?php matchcredit_title( 'rg_integre_titre' ); ?></h2>
		</div>

		<div class="tools-edit-grid tools-edit-grid--4">
			<?php foreach ( array( 'rg_integre_1', 'rg_integre_2', 'rg_integre_3', 'rg_integre_4' ) as $i => $integre_key ) :
				$integre = get_field( $integre_key );
				if ( ! $integre ) continue;
				?>
				<div class="tool-edit-card">
					<div class="card-num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></div>
					<h3><?php echo esc_html( $integre['titre'] ); ?></h3>
					<p><?php echo esc_html( $integre['texte'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
