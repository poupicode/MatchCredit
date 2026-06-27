<section class="page-section page-section--white">
	<div class="container">
		<div class="section-intro">
			<div class="eyebrow"><?php the_field( 'cap_hcsf_eyebrow' ); ?></div>
			<h2 class="section-h section-h--sm"><?php matchcredit_title( 'cap_hcsf_titre' ); ?></h2>
		</div>

		<div class="chiffres-grid">
			<?php foreach ( array( 'cap_hcsf_chiffre_1', 'cap_hcsf_chiffre_2', 'cap_hcsf_chiffre_3' ) as $chiffre_key ) :
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

		<div class="section-intro section-intro--lead">
			<p class="lead-text"><?php the_field( 'cap_hcsf_texte' ); ?></p>
		</div>
	</div>
</section>
