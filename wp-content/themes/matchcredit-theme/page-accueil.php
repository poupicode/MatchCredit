<?php
/**
 * Template Name: Page d'accueil
 */

get_header();
?>

<main class="site-main page-accueil">
	<?php
	matchcredit_section( 'hero' );
	matchcredit_section( 'projet' );
	matchcredit_section( 'chiffres' );
	matchcredit_section( 'methode' );
	matchcredit_section( 'outils' );
	matchcredit_section( 'simulateur' );
	matchcredit_section( 'pourquoi' );
	matchcredit_section( 'avis' );
	matchcredit_section( 'parrainage' );
	matchcredit_section( 'agence' );
	matchcredit_section( 'faq' );
	matchcredit_section( 'immatriculations' );
	matchcredit_section( 'cta-final' );
	?>
</main>

<?php get_footer(); ?>
