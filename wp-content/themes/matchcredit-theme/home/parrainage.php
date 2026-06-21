<section class="parrain-edit">
	<div class="container">
		<div class="parrain-edit-grid">
			<div>
				<div class="eyebrow"><?php the_field( 'parrainage_etiquette' ); ?></div>
				<h2><?php matchcredit_title( 'parrainage_titre' ); ?></h2>
				<p><?php the_field( 'parrainage_texte' ); ?></p>
				<?php matchcredit_link( 'parrainage_bouton', 'btn-yellow', 14 ); ?>
			</div>
			<div class="amount-block">
				<div class="lbl"><?php the_field( 'parrainage_label_montant' ); ?></div>
				<div class="num"><?php the_field( 'parrainage_montant' ); ?></div>
				<div class="sub"><?php the_field( 'parrainage_mention_montant' ); ?></div>
				<div class="conditions"><?php the_field( 'parrainage_mention_legale' ); ?></div>
			</div>
		</div>
	</div>
</section>
