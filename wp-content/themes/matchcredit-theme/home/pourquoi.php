<?php
$icons = array(
	'<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path>',
	'<circle cx="9" cy="8" r="3.5"></circle><path d="M3 21c0-3.3 2.7-6 6-6s6 2.7 6 6"></path><circle cx="17" cy="9" r="2.5"></circle><path d="M21 19c0-2.2-1.6-4-3.8-4.4"></path>',
	'<circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path>',
	'<path d="M3 12a9 9 0 0 1 18 0v5a2 2 0 0 1-2 2h-2v-7h4"></path><path d="M3 12v5a2 2 0 0 0 2 2h2v-7H3"></path>',
);
?>
<section class="section-pourquoi">
	<div class="container">
		<div class="section-intro section-intro--pourquoi">
			<div class="eyebrow"><?php the_field( 'pourquoi_etiquette' ); ?></div>
			<h2 class="section-h section-h--sm"><?php matchcredit_title( 'pourquoi_titre' ); ?></h2>
		</div>

		<div class="why-edit-grid">
			<?php
			$pourquoi_nb_raisons = (int) get_field( 'pourquoi_nb_raisons' );
			foreach ( array_slice( array( 'raison_1', 'raison_2', 'raison_3', 'raison_4' ), 0, $pourquoi_nb_raisons ) as $i => $raison_key ) :
				$raison = get_field( $raison_key );
				if ( ! $raison ) continue;
				?>
				<div class="why-edit-card">
					<div class="why-edit-icon">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><?php echo $icons[ $i % 4 ]; ?></svg>
					</div>
					<h3><?php echo matchcredit_strip_title_p( $raison['titre'] ); ?> <span class="ital"><?php echo esc_html( $raison['sous_titre'] ); ?></span></h3>
					<p><?php echo esc_html( $raison['texte'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
