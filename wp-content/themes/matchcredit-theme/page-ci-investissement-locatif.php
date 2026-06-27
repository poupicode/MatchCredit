<?php
/**
 * Template Name: CI — Investissement locatif
 */

get_header();
?>

<main class="site-main page-ci-investissement-locatif">
	<?php
	matchcredit_section( 'hero', 'ci-investissement-locatif' );
	matchcredit_section( 'intro', 'ci-investissement-locatif' );
	matchcredit_section( 'famille', 'ci-investissement-locatif' );
	matchcredit_section( 'vigilance', 'ci-investissement-locatif' );
	matchcredit_section( 'cta-final', 'shared' );
	?>
</main>

<?php get_footer(); ?>
