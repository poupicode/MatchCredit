<section class="page-section page-section--cream">
	<div class="container">
		<div class="page-split-head">
			<div class="eyebrow"><?php the_field( 'fg_comparatif_eyebrow' ); ?></div>
		</div>
		<div class="page-split">
			<div class="page-split-aside page-split-aside--sticky">
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'fg_comparatif_titre' ); ?></h2>
			</div>

			<div class="page-split-content">
				<table class="page-table">
					<thead>
						<tr>
							<th><?php the_field( 'fg_comparatif_col1' ); ?></th>
							<th><?php the_field( 'fg_comparatif_col2' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( array( 'fg_comparatif_ligne_1', 'fg_comparatif_ligne_2', 'fg_comparatif_ligne_3' ) as $ligne_key ) :
							$ligne = get_field( $ligne_key );
							if ( ! $ligne ) continue;
							?>
							<tr>
								<td><strong><?php echo esc_html( $ligne['col1'] ); ?></strong></td>
								<td><?php echo esc_html( $ligne['col2'] ); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<p class="page-note"><strong><?php the_field( 'fg_comparatif_note_label' ); ?></strong> <?php the_field( 'fg_comparatif_note_texte' ); ?></p>
			</div>
		</div>
	</div>
</section>
