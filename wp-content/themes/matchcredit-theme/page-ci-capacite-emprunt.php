<?php
/**
 * Template Name: CI — Capacité d'emprunt
 */

get_header();
?>

<main class="site-main page-ci-capacite-emprunt">
	<?php
	matchcredit_section( 'hero', 'ci-capacite-emprunt' );
	matchcredit_section( 'definition', 'ci-capacite-emprunt' );
	matchcredit_section( 'reste-a-vivre', 'ci-capacite-emprunt' );
	matchcredit_section( 'hcsf', 'ci-capacite-emprunt' );
	matchcredit_section( 'etapes', 'ci-capacite-emprunt' );
	matchcredit_section( 'cta-final', 'shared' );
	?>
</main>

<?php get_footer(); ?>
