<section class="page-section page-section--white">
	<div class="container">
		<div class="page-split-head">
			<div class="eyebrow"><?php the_field( 'il_vigilance_eyebrow' ); ?></div>
		</div>
		<div class="page-split">
			<div class="page-split-aside page-split-aside--sticky">
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'il_vigilance_titre' ); ?></h2>
			</div>
			<div class="page-split-content">
				<ul class="page-steps">
					<?php foreach ( array( 'il_vigilance_1', 'il_vigilance_2', 'il_vigilance_3' ) as $point_key ) :
						$point = get_field( $point_key );
						if ( ! $point ) continue;
						?>
						<li class="page-step">
							<div>
								<h3><?php echo esc_html( $point['titre'] ); ?></h3>
								<p><?php echo esc_html( $point['texte'] ); ?></p>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>
