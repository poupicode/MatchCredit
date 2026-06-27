<?php
/**
 * Template Name: CI — Coup de cœur immobilier
 */

get_header();
?>

<main class="site-main page-ci-coup-de-coeur">
	<?php
	matchcredit_section( 'hero', 'ci-coup-de-coeur' );
	matchcredit_section( 'facteurs', 'ci-coup-de-coeur' );
	matchcredit_section( 'stats', 'ci-coup-de-coeur' );
	matchcredit_section( 'financer', 'ci-coup-de-coeur' );
	matchcredit_section( 'cta-final', 'shared' );
	?>
</main>

<?php get_footer(); ?>
