<section class="page-section page-section--cream">
	<div class="container">
		<div class="page-split-head">
			<div class="eyebrow"><?php the_field( 'cap_etapes_eyebrow' ); ?></div>
		</div>
		<div class="page-split">
			<div class="page-split-aside page-split-aside--sticky">
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'cap_etapes_titre' ); ?></h2>
			</div>
			<div class="page-split-content">
				<ul class="page-steps">
					<?php foreach ( array( 'cap_etape_1', 'cap_etape_2', 'cap_etape_3' ) as $etape_key ) :
						$etape = get_field( $etape_key );
						if ( ! $etape ) continue;
						?>
						<li class="page-step">
							<div>
								<h3><?php echo esc_html( $etape['titre'] ); ?></h3>
								<p><?php echo esc_html( $etape['texte'] ); ?></p>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>
