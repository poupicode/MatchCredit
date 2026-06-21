<section class="how">
	<div class="container">
		<div class="how-intro">
			<div>
				<div class="eyebrow eyebrow--yellow"><?php the_field( 'methode_etiquette' ); ?></div>
				<h2 class="section-h"><?php matchcredit_title( 'methode_titre' ); ?></h2>
			</div>
			<p class="how-intro-text"><?php the_field( 'methode_texte_intro' ); ?></p>
		</div>

		<div class="steps">
			<?php
			$methode_nb_etapes = (int) get_field( 'methode_nb_etapes' );
			foreach ( array_slice( array( 'etape_1', 'etape_2', 'etape_3' ), 0, $methode_nb_etapes ) as $etape_key ) :
				$etape = get_field( $etape_key );
				if ( ! $etape ) continue;
				?>
				<div class="step-card">
					<div class="step-num"><?php echo esc_html( $etape['numero'] ); ?></div>
					<h3><?php echo matchcredit_strip_title_p( $etape['titre'] ); ?></h3>
					<p><?php echo esc_html( $etape['texte'] ); ?></p>
					<div class="step-meta">
						<?php
						echo esc_html( $etape['tag_1'] );
						if ( ! empty( $etape['tag_2'] ) ) {
							echo ' · ' . esc_html( $etape['tag_2'] );
						}
						?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
