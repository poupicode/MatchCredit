<?php
/**
 * Template Name: CI — Frais de notaire
 */

get_header();
?>

<main class="site-main page-ci-frais-notaire">
	<?php
	matchcredit_section( 'hero', 'ci-frais-notaire' );
	matchcredit_section( 'composition', 'ci-frais-notaire' );
	matchcredit_section( 'neuf-ancien', 'ci-frais-notaire' );
	matchcredit_section( 'calculette', 'ci-frais-notaire' );
	matchcredit_section( 'cta-final', 'shared' );
	?>
</main>

<?php get_footer(); ?>
