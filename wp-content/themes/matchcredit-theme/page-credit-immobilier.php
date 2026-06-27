<?php
/**
 * Template Name: Page Crédit immobilier
 */

get_header();
?>

<main class="site-main page-credit-immobilier">
	<?php
	matchcredit_section( 'hero', 'credit-immobilier' );
	matchcredit_section( 'intro', 'credit-immobilier' );
	matchcredit_section( 'financement', 'credit-immobilier' );
	matchcredit_section( 'services', 'credit-immobilier' );
	matchcredit_section( 'profils', 'credit-immobilier' );
	matchcredit_section( 'calculettes', 'credit-immobilier' );
	matchcredit_section( 'citation', 'credit-immobilier' );
	matchcredit_section( 'conseils', 'credit-immobilier' );
	matchcredit_section( 'cta-final', 'shared' );
	?>
</main>

<?php get_footer(); ?>
