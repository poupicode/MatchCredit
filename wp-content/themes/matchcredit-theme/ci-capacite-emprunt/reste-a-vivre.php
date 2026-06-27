<section class="page-section page-section--cream">
	<div class="container">
		<div class="page-split-head">
			<div class="eyebrow"><?php the_field( 'cap_reste_eyebrow' ); ?></div>
		</div>
		<div class="page-split">
			<div class="page-split-aside page-split-aside--sticky">
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'cap_reste_titre' ); ?></h2>
			</div>
			<div class="page-split-content">
				<div class="section-intro">
					<?php the_field( 'cap_reste_texte' ); ?>
				</div>
				<ul class="page-list">
					<?php
					$cap_reste_charges = explode( "\n", (string) get_field( 'cap_reste_charges' ) );
					foreach ( $cap_reste_charges as $charge ) :
						$charge = trim( $charge );
						if ( ! $charge ) continue;
						?>
						<li><?php echo esc_html( $charge ); ?></li>
					<?php endforeach; ?>
				</ul>
				<p class="page-note"><strong><?php the_field( 'cap_reste_note_label' ); ?></strong> <?php the_field( 'cap_reste_note_texte' ); ?></p>
			</div>
		</div>
	</div>
</section>
