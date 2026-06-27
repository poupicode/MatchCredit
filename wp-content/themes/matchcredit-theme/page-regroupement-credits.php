<?php
/**
 * Template Name: RC — Regroupement de crédits
 */

get_header();
?>

<main class="site-main page-regroupement-credits">
	<?php
	matchcredit_section( 'hero', 'regroupement-credits' );
	matchcredit_section( 'intro', 'regroupement-credits' );
	matchcredit_section( 'avantages', 'regroupement-credits' );
	matchcredit_section( 'comparatif', 'regroupement-credits' );
	matchcredit_section( 'exemple', 'regroupement-credits' );
	matchcredit_section( 'integre', 'regroupement-credits' );
	matchcredit_section( 'citation', 'regroupement-credits' );
	matchcredit_section( 'cta-final', 'shared' );
	?>
</main>

<?php get_footer(); ?>
