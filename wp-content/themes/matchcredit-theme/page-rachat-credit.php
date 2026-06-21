<?php
/**
 * Template Name: Page Rachat de crédit
 */

get_header();
?>

<main class="site-main page-rachat-credit">
	<?php
	matchcredit_section( 'hero', 'rachat-credit' );
	matchcredit_section( 'intro', 'rachat-credit' );
	matchcredit_section( 'questions', 'rachat-credit' );
	matchcredit_section( 'situations', 'rachat-credit' );
	matchcredit_section( 'documents', 'rachat-credit' );
	matchcredit_section( 'cta-final', 'shared' );
	?>
</main>

<?php get_footer(); ?>
