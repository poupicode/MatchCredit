<section class="page-section page-section--cream">
	<div class="container">
		<div class="page-split-head">
			<div class="eyebrow"><?php the_field( 'rs_calcul_eyebrow' ); ?></div>
		</div>
		<div class="page-split">
			<div class="page-split-aside page-split-aside--sticky">
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'rs_calcul_titre' ); ?></h2>
			</div>

			<div class="page-split-content">
				<table class="page-table">
					<thead>
						<tr>
							<th><?php the_field( 'rs_calcul_col1' ); ?></th>
							<th><?php the_field( 'rs_calcul_col2' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( array( 'rs_calcul_ligne_1', 'rs_calcul_ligne_2', 'rs_calcul_ligne_3', 'rs_calcul_ligne_4' ) as $ligne_key ) :
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
			</div>
		</div>
	</div>
</section>
