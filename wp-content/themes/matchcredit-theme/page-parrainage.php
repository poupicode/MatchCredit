<?php
/**
 * Template Name: Page Parrainage
 */

get_header();
?>

<main class="site-main page-parrainage">
	<?php
	matchcredit_section( 'hero', 'parrainage' );
	matchcredit_section( 'mecanique', 'parrainage' );
	matchcredit_section( 'formulaire', 'parrainage' );
	matchcredit_section( 'cta-final', 'shared' );
	?>
</main>

<?php get_footer(); ?>
