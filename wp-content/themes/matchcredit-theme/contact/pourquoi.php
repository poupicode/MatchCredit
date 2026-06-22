<?php
$contact_icones = array(
	'<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path>',
	'<path d="M3 18v-6a9 9 0 0 1 18 0v6"></path><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3v5Z"></path><path d="M3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3v5Z"></path>',
	'<circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path>',
);
?>
<section class="section-contact-pourquoi">
	<div class="container">
		<div class="section-intro">
			<h2 class="section-h section-h--sm"><?php the_field( 'contact_pourquoi_titre' ); ?></h2>
		</div>

		<div class="contact-why-grid">
			<?php foreach ( array( 'raison_1', 'raison_2', 'raison_3' ) as $i => $raison_key ) : ?>
				<?php $raison = get_field( $raison_key ); ?>
				<?php if ( ! $raison ) continue; ?>
				<div class="contact-why-card">
					<div class="contact-why-icon">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><?php echo $contact_icones[ $i % 3 ]; ?></svg>
					</div>
					<h3><?php echo matchcredit_strip_title_p( $raison['titre'] ); ?> <span class="ital"><?php echo esc_html( $raison['sous_titre'] ); ?></span></h3>
					<p><?php echo esc_html( $raison['texte'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
