<?php
$icons = array(
	'<circle cx="12" cy="12" r="9"></circle><path d="M8 12h8M12 8v8"></path>',
	'<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path>',
	'<circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path>',
);
?>
<section class="page-section page-section--cream">
	<div class="container">
		<div class="section-intro">
			<div class="eyebrow"><?php the_field( 'rrt_services_eyebrow' ); ?></div>
			<h2 class="section-h section-h--sm"><?php matchcredit_title( 'rrt_services_titre' ); ?></h2>
		</div>

		<div class="why-edit-grid">
			<?php foreach ( array( 'rrt_service_1', 'rrt_service_2', 'rrt_service_3' ) as $i => $service_key ) :
				$service = get_field( $service_key );
				if ( ! $service ) continue;
				?>
				<div class="why-edit-card">
					<div class="why-edit-icon">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><?php echo $icons[ $i % 3 ]; ?></svg>
					</div>
					<h3><?php echo esc_html( $service['titre'] ); ?></h3>
					<p><?php echo esc_html( $service['texte'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
