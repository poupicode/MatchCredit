<section class="page-section page-section--white">
	<div class="container">
		<div class="section-intro">
			<div class="eyebrow"><?php the_field( 'rc_situations_eyebrow' ); ?></div>
			<h2 class="section-h section-h--sm"><?php matchcredit_title( 'rc_situations_titre' ); ?></h2>
		</div>

		<div class="tools-edit-grid">
			<?php foreach ( array( 'rc_situation_1', 'rc_situation_2', 'rc_situation_3' ) as $i => $situation_key ) :
				$situation = get_field( $situation_key );
				if ( ! $situation ) continue;
				?>
				<div class="tool-edit-card">
					<div class="card-num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></div>
					<h3><?php echo esc_html( $situation['titre'] ); ?></h3>
					<p><?php echo esc_html( $situation['texte'] ); ?></p>
					<?php if ( ! empty( $situation['lien']['url'] ) ) : ?>
						<a href="<?php echo esc_url( $situation['lien']['url'] ); ?>" class="tool-cta"><?php echo esc_html( $situation['lien']['title'] ); ?></a>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
