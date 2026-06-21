<section class="section-chiffres">
	<div class="container">
		<div class="chiffres-grid">
			<?php
			$chiffres_nb = (int) get_field( 'chiffres_nb' );
			foreach ( array_slice( array( 'chiffre_1', 'chiffre_2', 'chiffre_3' ), 0, $chiffres_nb ) as $chiffre_key ) :
				$chiffre = get_field( $chiffre_key );
				if ( ! $chiffre ) continue;
				?>
				<div class="chiffres-item">
					<div class="chiffres-label"><?php echo esc_html( $chiffre['label'] ); ?></div>
					<div class="chiffres-val"><?php echo esc_html( $chiffre['valeur'] ); ?><span class="unit"><?php echo esc_html( $chiffre['unite'] ); ?></span></div>
					<div class="chiffres-text"><?php echo esc_html( $chiffre['sous_label'] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
