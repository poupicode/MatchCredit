<?php
$rt_critere_icons = array(
	'<circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path>',
	'<path d="M3 3v18h18"></path><path d="M7 14l4-4 3 3 5-6"></path>',
	'<path d="M5 12h14M15 6l6 6-6 6"></path><path d="M9 6L3 12l6 6"></path>',
	'<rect x="3" y="3" width="18" height="18" rx="2"></rect><path d="M3 9h18M9 21V9"></path>',
);
?>
<section class="page-section page-section--cream">
	<div class="container">
		<div class="section-intro">
			<div class="eyebrow"><?php the_field( 'rt_criteres_eyebrow' ); ?></div>
			<h2 class="section-h section-h--sm"><?php matchcredit_title( 'rt_criteres_titre' ); ?></h2>
		</div>

		<div class="tools-edit-grid tools-edit-grid--4">
			<?php
			$rt_criteres_nb = (int) get_field( 'rt_criteres_nb' );
			foreach ( array_slice( array( 'rt_critere_1', 'rt_critere_2', 'rt_critere_3', 'rt_critere_4' ), 0, $rt_criteres_nb ) as $i => $critere_key ) :
				$critere = get_field( $critere_key );
				if ( ! $critere ) continue;
				?>
				<div class="tool-edit-card">
					<div class="why-edit-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><?php echo $rt_critere_icons[ $i % 4 ]; ?></svg></div>
					<h3><?php echo esc_html( $critere['titre'] ); ?></h3>
					<p><?php echo esc_html( $critere['texte'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
