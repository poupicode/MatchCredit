<?php
/**
 * Template Name: CI — Frais de garantie
 */

get_header();
?>

<main class="site-main page-ci-frais-garantie">
	<?php
	matchcredit_section( 'hero', 'ci-frais-garantie' );
	matchcredit_section( 'definition', 'ci-frais-garantie' );
	matchcredit_section( 'comparatif', 'ci-frais-garantie' );
	matchcredit_section( 'calculette', 'ci-frais-garantie' );
	matchcredit_section( 'cta-final', 'shared' );
	?>
</main>

<?php get_footer(); ?>
