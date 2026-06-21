<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface MC_Tools_Preset_Interface {

	/**
	 * Liste des variables que le preset peut accepter (le client associe ses
	 * champs à ces clés). $variables ne contient que les clés effectivement
	 * fournies par la calculette — un preset doit gérer les absences.
	 *
	 * @param array<string,float> $variables
	 * @return array<string,float> Résultats nommés (1 ou plusieurs sorties).
	 */
	public function compute( array $variables ): array;
}

/**
 * Mensualité / capacité d'emprunt / durée de remboursement — même formule de
 * prêt amortissable, l'inconnue à isoler dépend des champs que le client a
 * associés (exactement une des trois doit être absente).
 *
 * Variables : capital, taux_annuel (en %, ex. 3.5), duree_mois.
 * Si l'une des trois est absente, elle est calculée et renvoyée seule.
 * Si les trois sont fournies, la mensualité théorique est recalculée
 * (sert de vérification / "ce que ça donnerait").
 */
class MC_Tools_Preset_Pret_Amortissable implements MC_Tools_Preset_Interface {

	public function compute( array $variables ): array {
		$capital = $variables['capital'] ?? null;
		$taux    = $variables['taux_annuel'] ?? null;
		$duree   = $variables['duree_mois'] ?? null;

		if ( null === $taux ) {
			throw new InvalidArgumentException( 'pret_amortissable : "taux_annuel" est requis.' );
		}

		$t = ( (float) $taux / 100 ) / 12; // taux mensuel

		if ( null === $capital && null !== $duree && isset( $variables['mensualite'] ) ) {
			$m = (float) $variables['mensualite'];
			return array(
				'capital' => $this->capitalFromMensualite( $m, $t, (float) $duree ),
			);
		}

		if ( null === $duree && null !== $capital && isset( $variables['mensualite'] ) ) {
			$m = (float) $variables['mensualite'];
			return array(
				'duree_mois' => $this->dureeFromMensualite( (float) $capital, $m, $t ),
			);
		}

		if ( null !== $capital && null !== $duree ) {
			return array(
				'mensualite' => $this->mensualite( (float) $capital, $t, (float) $duree ),
			);
		}

		throw new InvalidArgumentException( 'pret_amortissable : combinaison de variables insuffisante (il faut taux_annuel + 2 des 3 : capital, duree_mois, mensualite).' );
	}

	private function mensualite( float $capital, float $t, float $duree_mois ): float {
		if ( 0.0 === $t ) {
			return $capital / $duree_mois;
		}
		return $capital * $t / ( 1 - ( 1 + $t ) ** -$duree_mois );
	}

	private function capitalFromMensualite( float $m, float $t, float $duree_mois ): float {
		if ( 0.0 === $t ) {
			return $m * $duree_mois;
		}
		return $m * ( 1 - ( 1 + $t ) ** -$duree_mois ) / $t;
	}

	private function dureeFromMensualite( float $capital, float $m, float $t ): float {
		if ( 0.0 === $t ) {
			return $capital / $m;
		}
		if ( $m <= $capital * $t ) {
			throw new InvalidArgumentException( 'pret_amortissable : mensualité insuffisante pour amortir ce capital à ce taux (durée infinie).' );
		}
		return -log( 1 - ( $capital * $t ) / $m ) / log( 1 + $t );
	}
}

/**
 * Frais de notaire (+ frais de garantie/hypothèque optionnels).
 *
 * ATTENTION : barème simplifié à valider par le client avant publication
 * réelle — les taux exacts varient par département et évoluent (droits de
 * mutation, émoluments dégressifs). Voir section 15 du cadrage : ne jamais
 * publier sans validation métier.
 *
 * Variables : type_bien ('ancien'|'neuf'), prix_terrain (optionnel),
 * prix_logement, negocie (0|1, réduit l'assiette des droits de mutation sur
 * la commission d'agence le cas échéant), montant_pret, cout_travaux
 * (optionnel), taille_ensemble (optionnel, non utilisé dans ce barème
 * simplifié — réservé à une future granularité).
 *
 * Sorties : 'frais_notaire' toujours ; 'frais_garantie' uniquement si
 * 'montant_pret' est fourni.
 */
class MC_Tools_Preset_Frais_Notaire implements MC_Tools_Preset_Interface {

	private const TAUX_ANCIEN = 0.075; // ~7.5% prix de vente, barème simplifié
	private const TAUX_NEUF   = 0.025; // ~2.5% prix de vente, barème simplifié
	private const TAUX_GARANTIE_HYPOTHEQUE = 0.015; // ~1.5% du montant du prêt, barème simplifié

	public function compute( array $variables ): array {
		$type_bien     = $variables['type_bien'] ?? 'ancien';
		$prix_terrain  = (float) ( $variables['prix_terrain'] ?? 0 );
		$prix_logement = (float) ( $variables['prix_logement'] ?? 0 );
		$negocie       = ! empty( $variables['negocie'] );

		$assiette = $prix_terrain + $prix_logement;

		if ( $negocie ) {
			// Réduction simplifiée : la commission d'agence négociée sort
			// partiellement de l'assiette des droits de mutation.
			$assiette *= 0.97;
		}

		$taux          = 'neuf' === $type_bien ? self::TAUX_NEUF : self::TAUX_ANCIEN;
		$frais_notaire = round( $assiette * $taux, 2 );

		$resultats = array( 'frais_notaire' => $frais_notaire );

		if ( isset( $variables['montant_pret'] ) ) {
			$montant_pret    = (float) $variables['montant_pret'];
			$cout_travaux    = (float) ( $variables['cout_travaux'] ?? 0 );
			$base_garantie   = $montant_pret + $cout_travaux;
			$frais_garantie  = round( $base_garantie * self::TAUX_GARANTIE_HYPOTHEQUE, 2 );

			$resultats['frais_garantie'] = $frais_garantie;
		}

		return $resultats;
	}
}

class MC_Tools_Presets {

	/** @return array<string,class-string<MC_Tools_Preset_Interface>> */
	private static function registry(): array {
		return array(
			'pret_amortissable' => MC_Tools_Preset_Pret_Amortissable::class,
			'frais_notaire'     => MC_Tools_Preset_Frais_Notaire::class,
		);
	}

	public static function get( string $slug ): MC_Tools_Preset_Interface {
		$registry = self::registry();

		if ( ! isset( $registry[ $slug ] ) ) {
			throw new InvalidArgumentException( sprintf( 'Preset inconnu : "%s".', $slug ) );
		}

		$class = $registry[ $slug ];
		return new $class();
	}

	/** @return string[] */
	public static function slugs(): array {
		return array_keys( self::registry() );
	}

	/**
	 * Métadonnées des variables attendues par chaque preset — utilisées par
	 * le builder admin pour proposer l'association champ → variable.
	 *
	 * @return array<string,array{slug:string,label:string,variables:array<int,array{id:string,label:string,required:bool}>}>
	 */
	public static function describe(): array {
		return array(
			'pret_amortissable' => array(
				'slug'      => 'pret_amortissable',
				'label'     => 'Prêt amortissable (mensualité / capacité / durée)',
				'variables' => array(
					array( 'id' => 'taux_annuel', 'label' => 'Taux annuel (%)', 'required' => true ),
					array( 'id' => 'capital', 'label' => 'Capital emprunté', 'required' => false ),
					array( 'id' => 'duree_mois', 'label' => 'Durée (mois)', 'required' => false ),
					array( 'id' => 'mensualite', 'label' => 'Mensualité', 'required' => false ),
				),
				'help'      => 'Associez exactement 2 des 3 variables capital / duree_mois / mensualite : la 3e sera calculée.',
			),
			'frais_notaire'     => array(
				'slug'      => 'frais_notaire',
				'label'     => 'Frais de notaire (+ frais de garantie optionnels)',
				'variables' => array(
					array( 'id' => 'type_bien', 'label' => "Type de bien ('ancien' ou 'neuf')", 'required' => false ),
					array( 'id' => 'prix_terrain', 'label' => 'Prix du terrain', 'required' => false ),
					array( 'id' => 'prix_logement', 'label' => 'Prix du logement', 'required' => false ),
					array( 'id' => 'negocie', 'label' => 'Bien négocié (0/1)', 'required' => false ),
					array( 'id' => 'montant_pret', 'label' => 'Montant du prêt (active le calcul des frais de garantie)', 'required' => false ),
					array( 'id' => 'cout_travaux', 'label' => 'Coût des travaux', 'required' => false ),
				),
				'help'      => 'Le champ montant_pret est optionnel : s\'il est associé, un 2e résultat "frais_garantie" devient disponible.',
			),
		);
	}
}
