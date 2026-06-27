<section class="page-section page-section--white">
	<div class="container">
		<div class="section-intro">
			<div class="eyebrow"><?php the_field( 'aide_outils_eyebrow' ); ?></div>
			<h2 class="section-h section-h--sm"><?php matchcredit_title( 'aide_outils_titre' ); ?></h2>
		</div>

		<div class="tools-edit-grid">
			<?php foreach ( array( 'aide_outil_1', 'aide_outil_2', 'aide_outil_3', 'aide_outil_4', 'aide_outil_5' ) as $i => $outil_key ) :
				$outil = get_field( $outil_key );
				if ( ! $outil ) continue;
				?>
				<div class="tool-edit-card">
					<div class="card-num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></div>
					<h3><?php echo esc_html( $outil['titre'] ); ?></h3>
					<p><?php echo esc_html( $outil['texte'] ); ?></p>
					<?php if ( ! empty( $outil['lien']['url'] ) ) : ?>
						<a href="<?php echo esc_url( $outil['lien']['url'] ); ?>" class="tool-cta"><?php echo esc_html( $outil['lien']['title'] ); ?></a>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
