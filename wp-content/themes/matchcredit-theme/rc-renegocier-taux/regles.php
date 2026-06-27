<section class="page-section page-section--cream">
	<div class="container">
		<div class="page-split-head">
			<div class="eyebrow"><?php the_field( 'rrt_regles_eyebrow' ); ?></div>
		</div>
		<div class="page-split">
			<div class="page-split-aside page-split-aside--sticky">
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'rrt_regles_titre' ); ?></h2>
			</div>

			<div class="page-split-content">
				<ul class="page-steps">
					<?php foreach ( array( 'rrt_regle_1', 'rrt_regle_2', 'rrt_regle_3', 'rrt_regle_4' ) as $regle_key ) :
						$regle = get_field( $regle_key );
						if ( ! $regle ) continue;
						?>
						<li class="page-step">
							<div>
								<h3><?php echo esc_html( $regle['titre'] ); ?></h3>
								<p><?php echo esc_html( $regle['texte'] ); ?></p>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>
