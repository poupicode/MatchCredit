<?php
/**
 * Template Name: Page Centre d'aide
 */

get_header();
?>

<main class="site-main page-centre-aide">
	<?php
	matchcredit_section( 'hero', 'centre-aide' );
	matchcredit_section( 'outils', 'centre-aide' );
	matchcredit_section( 'faq', 'centre-aide' );
	matchcredit_section( 'liens', 'centre-aide' );
	?>
</main>

<?php get_footer(); ?>
