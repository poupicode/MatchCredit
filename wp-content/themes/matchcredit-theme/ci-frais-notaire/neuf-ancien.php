<section class="page-section page-section--cream">
	<div class="container">
		<div class="page-split-head">
			<div class="eyebrow"><?php the_field( 'fn_neufancien_eyebrow' ); ?></div>
		</div>
		<div class="page-split">
			<div class="page-split-aside page-split-aside--sticky">
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'fn_neufancien_titre' ); ?></h2>
			</div>

			<div class="page-split-content">
				<table class="page-table">
					<thead>
						<tr>
							<th><?php the_field( 'fn_neufancien_col1' ); ?></th>
							<th><?php the_field( 'fn_neufancien_col2' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( array( 'fn_neufancien_ligne_1', 'fn_neufancien_ligne_2', 'fn_neufancien_ligne_3' ) as $ligne_key ) :
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
				<p class="page-note"><strong><?php the_field( 'fn_neufancien_note_label' ); ?></strong> <?php the_field( 'fn_neufancien_note_texte' ); ?></p>
			</div>
		</div>
	</div>
</section>
