<?php
/**
 * Template Name: Page Contact
 */

get_header();
?>

<main class="site-main page-contact">
	<?php
	matchcredit_section( 'hero', 'contact' );
	matchcredit_section( 'formulaire', 'contact' );
	matchcredit_section( 'pourquoi', 'contact' );
	matchcredit_section( 'equipe', 'contact' );
	matchcredit_section( 'infos', 'contact' );
	matchcredit_section( 'metier', 'contact' );
	?>
</main>

<?php get_footer(); ?>
