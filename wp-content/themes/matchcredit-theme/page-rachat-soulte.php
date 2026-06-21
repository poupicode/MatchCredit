<?php
/**
 * Template Name: Sous-page Rachat de soulte
 */

get_header();
?>

<main class="site-main page-rachat-soulte">
	<?php
	matchcredit_section( 'hero', 'rachat-soulte' );
	matchcredit_section( 'intro', 'rachat-soulte' );
	matchcredit_section( 'definition', 'rachat-soulte' );
	matchcredit_section( 'calcul', 'rachat-soulte' );
	matchcredit_section( 'etapes', 'rachat-soulte' );
	matchcredit_section( 'accompagnement', 'rachat-soulte' );
	matchcredit_section( 'cta-final', 'shared' );
	?>
</main>

<?php get_footer(); ?>
