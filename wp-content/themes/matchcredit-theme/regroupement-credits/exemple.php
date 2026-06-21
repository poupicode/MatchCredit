<?php
$rg_exemple_avant = explode( "\n", (string) get_field( 'rg_exemple_avant_liste' ) );
?>
<section class="page-section page-section--white">
	<div class="container">
		<div class="page-split-head">
			<div class="eyebrow"><?php the_field( 'rg_exemple_eyebrow' ); ?></div>
		</div>
		<div class="page-split">
			<div class="page-split-aside">
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'rg_exemple_titre' ); ?></h2>
			</div>

			<div class="page-split-content">
				<div class="section-intro">
					<?php the_field( 'rg_exemple_texte' ); ?>
				</div>

				<div class="example-card">
					<div class="example-before">
						<?php foreach ( $rg_exemple_avant as $line ) :
							$line = trim( $line );
							if ( ! $line ) continue;
							$parts = array_map( 'trim', explode( '—', $line, 2 ) );
							?>
							<div class="example-line">
								<span><?php echo esc_html( $parts[0] ); ?></span>
								<strong><?php echo esc_html( $parts[1] ?? '' ); ?></strong>
							</div>
						<?php endforeach; ?>
					</div>

					<div class="example-arrow">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"></path></svg>
					</div>

					<div class="example-after">
						<div class="lbl"><?php the_field( 'rg_exemple_apres_label' ); ?></div>
						<div class="val"><?php the_field( 'rg_exemple_apres_montant' ); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
