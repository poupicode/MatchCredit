<section class="page-section page-section--white">
	<div class="container">
		<div class="section-intro section-intro--lead">
			<div class="eyebrow"><?php the_field( 'fn_composition_eyebrow' ); ?></div>
			<p class="lead-text"><?php the_field( 'fn_composition_texte' ); ?></p>
		</div>

		<div class="chiffres-grid">
			<?php foreach ( array( 'fn_composition_part_1', 'fn_composition_part_2', 'fn_composition_part_3' ) as $part_key ) :
				$part = get_field( $part_key );
				if ( ! $part ) continue;
				?>
				<div class="chiffres-item">
					<div class="chiffres-label"><?php echo esc_html( $part['label'] ); ?></div>
					<div class="chiffres-val"><?php echo esc_html( $part['valeur'] ); ?><span class="unit"><?php echo esc_html( $part['unite'] ); ?></span></div>
					<div class="chiffres-text"><?php echo esc_html( $part['sous_label'] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
		<p class="chiffres-source"><?php the_field( 'fn_composition_source' ); ?></p>
	</div>
</section>
