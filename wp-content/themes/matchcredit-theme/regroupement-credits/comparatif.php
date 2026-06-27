<section class="page-section page-section--white">
	<div class="container">
		<div class="page-split-head">
			<div class="eyebrow"><?php the_field( 'rg_comparatif_eyebrow' ); ?></div>
		</div>
		<div class="page-split">
			<div class="page-split-aside page-split-aside--sticky">
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'rg_comparatif_titre' ); ?></h2>
			</div>

			<div class="page-split-content">
				<table class="page-table">
					<thead>
						<tr>
							<th><?php the_field( 'rg_comparatif_col1' ); ?></th>
							<th><?php the_field( 'rg_comparatif_col2' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( array( 'rg_comparatif_ligne_1', 'rg_comparatif_ligne_2', 'rg_comparatif_ligne_3' ) as $ligne_key ) :
							$ligne = get_field( $ligne_key );
							if ( ! $ligne ) continue;
							?>
							<tr>
								<td><?php echo esc_html( $ligne['col1'] ); ?></td>
								<td><?php echo esc_html( $ligne['col2'] ); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
