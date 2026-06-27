<section class="page-section page-section--cream">
	<div class="container">
		<div class="section-intro section-intro--lead">
			<div class="eyebrow"><?php the_field( 'cdc_stats_eyebrow' ); ?></div>
			<p class="lead-text"><?php the_field( 'cdc_stats_texte' ); ?></p>
		</div>

		<div class="chiffres-grid">
			<?php foreach ( array( 'cdc_stat_1', 'cdc_stat_2', 'cdc_stat_3' ) as $stat_key ) :
				$stat = get_field( $stat_key );
				if ( ! $stat ) continue;
				?>
				<div class="chiffres-item">
					<div class="chiffres-label"><?php echo esc_html( $stat['label'] ); ?></div>
					<div class="chiffres-val"><?php echo esc_html( $stat['valeur'] ); ?><span class="unit"><?php echo esc_html( $stat['unite'] ); ?></span></div>
					<div class="chiffres-text"><?php echo esc_html( $stat['sous_label'] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
		<p class="chiffres-source"><?php the_field( 'cdc_stats_source' ); ?></p>
	</div>
</section>
