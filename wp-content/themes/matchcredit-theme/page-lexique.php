<?php
/**
 * Template Name: Page Lexique
 */

get_header();
?>

<main class="site-main page-lexique">
	<?php
	matchcredit_section( 'hero', 'lexique' );
	matchcredit_section( 'liste', 'lexique' );
	?>
</main>

<?php get_footer(); ?>
