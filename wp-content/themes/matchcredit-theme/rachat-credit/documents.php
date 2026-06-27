<section class="page-section page-section--cream">
	<div class="container">
		<div class="section-intro section-intro--center">
			<div class="eyebrow"><?php the_field( 'rc_documents_eyebrow' ); ?></div>
			<h2 class="section-h section-h--sm"><?php matchcredit_title( 'rc_documents_titre' ); ?></h2>
		</div>

		<div class="page-list-grid">
			<ul class="page-list">
				<?php
				$rc_documents_liste = explode( "\n", (string) get_field( 'rc_documents_liste' ) );
				foreach ( $rc_documents_liste as $document ) :
					$document = trim( $document );
					if ( ! $document ) continue;
					?>
					<li><?php echo esc_html( $document ); ?></li>
				<?php endforeach; ?>
			</ul>

			<p class="page-note"><strong>Bon à savoir :</strong> <?php the_field( 'rc_documents_note' ); ?></p>
		</div>
	</div>
</section>
