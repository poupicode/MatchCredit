<?php
$icons = array(
	'<circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path>',
	'<path d="M3 12a9 9 0 0 1 18 0v5a2 2 0 0 1-2 2h-2v-7h4"></path><path d="M3 12v5a2 2 0 0 0 2 2h2v-7H3"></path>',
	'<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path>',
);
?>
<section class="page-section page-section--cream">
	<div class="container">
		<div class="section-intro">
			<div class="eyebrow"><?php the_field( 'rg_avantages_eyebrow' ); ?></div>
			<h2 class="section-h section-h--sm"><?php matchcredit_title( 'rg_avantages_titre' ); ?></h2>
		</div>

		<div class="why-edit-grid">
			<?php foreach ( array( 'rg_avantage_1', 'rg_avantage_2', 'rg_avantage_3' ) as $i => $avantage_key ) :
				$avantage = get_field( $avantage_key );
				if ( ! $avantage ) continue;
				?>
				<div class="why-edit-card">
					<div class="why-edit-icon">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><?php echo $icons[ $i % 3 ]; ?></svg>
					</div>
					<h3><?php echo esc_html( $avantage['titre'] ); ?></h3>
					<p><?php echo esc_html( $avantage['texte'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
