<section class="compare" id="simulateur">
	<div class="container">
		<div class="section-intro section-intro--compare">
			<div class="eyebrow"><?php the_field( 'simulateur_etiquette' ); ?></div>
			<h2 class="section-h"><?php matchcredit_title( 'simulateur_titre' ); ?></h2>
			<p><?php the_field( 'simulateur_texte_intro' ); ?></p>
		</div>

		<div class="compare-grid" data-compare
			data-rest-url="<?php echo esc_url( rest_url( 'matchcredit/v1/compute' ) ); ?>"
			data-slug-1="simu-comparatif-banque"
			data-slug-2="simu-comparatif-matchcredit"
			data-taux-1="<?php echo esc_attr( get_field( 'colonne_1_taux_defaut' ) ); ?>"
			data-taux-2="<?php echo esc_attr( get_field( 'colonne_2_taux_defaut' ) ); ?>">
			<div class="compare-controls">
				<h4>Votre projet</h4>
				<div class="cc-row">
					<div class="cc-label"><span>Montant emprunté</span><span data-compare-montant-out><?php echo number_format( (float) get_field( 'montant_defaut' ), 0, ',', ' ' ); ?> €</span></div>
					<input type="range" min="50000" max="600000" step="5000" value="<?php the_field( 'montant_defaut' ); ?>" data-compare-montant>
				</div>
				<div class="cc-row cc-row--last">
					<div class="cc-label"><span>Durée</span><span data-compare-duree-out><?php the_field( 'duree_defaut' ); ?> ans</span></div>
					<input type="range" min="10" max="30" step="1" value="<?php the_field( 'duree_defaut' ); ?>" data-compare-duree>
				</div>
			</div>

			<div class="compare-out">
				<div class="bar-block">
					<div class="bar-label">
						<span class="who"><?php the_field( 'colonne_1_label' ); ?></span>
						<span class="val" data-compare-val="1"><?php the_field( 'colonne_1_mensualite_defaut' ); ?> €<span class="bar-unit">/mois</span></span>
					</div>
					<div class="bar-bg"><div class="bar-fill bank" data-compare-bar="1" style="--fill: 100%;"></div></div>
				</div>

				<div class="bar-block">
					<div class="bar-label">
						<span class="who who--accent"><?php the_field( 'colonne_2_label' ); ?></span>
						<span class="val" data-compare-val="2"><?php the_field( 'colonne_2_mensualite_defaut' ); ?> €<span class="bar-unit">/mois</span></span>
					</div>
					<div class="bar-bg"><div class="bar-fill mc" data-compare-bar="2" style="--fill: 94%;"></div></div>
				</div>

				<div class="savings-box">
					<div>
						<div class="label"><?php the_field( 'economie_label' ); ?></div>
						<div class="val" data-compare-economie><?php echo number_format( (float) get_field( 'economie_valeur_defaut' ), 0, ',', ' ' ); ?> €</div>
						<div class="small"><?php the_field( 'economie_sous_label' ); ?></div>
					</div>
					<?php matchcredit_link( 'simulateur_bouton', 'btn-yellow', 12 ); ?>
				</div>
			</div>
		</div>
	</div>
</section>
