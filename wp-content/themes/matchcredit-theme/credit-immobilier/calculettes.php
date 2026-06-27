<section class="page-section page-section--white">
	<div class="container">
		<div class="section-intro">
			<div class="eyebrow"><?php the_field( 'cri_calculettes_eyebrow' ); ?></div>
			<h2 class="section-h section-h--sm"><?php matchcredit_title( 'cri_calculettes_titre' ); ?></h2>
		</div>

		<div class="tools-edit-grid">
			<?php foreach ( array( 'cri_calculette_1', 'cri_calculette_2', 'cri_calculette_3', 'cri_calculette_4', 'cri_calculette_5' ) as $i => $calculette_key ) :
				$lien = get_field( $calculette_key );
				if ( ! $lien || empty( $lien['url'] ) ) continue;
				?>
				<div class="tool-edit-card">
					<div class="card-num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></div>
					<h3><?php echo esc_html( $lien['title'] ); ?></h3>
					<a href="<?php echo esc_url( $lien['url'] ); ?>" class="tool-cta">Lancer la calculette<?php matchcredit_icon_arrow( 14 ); ?></a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
