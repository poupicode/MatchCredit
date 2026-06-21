<?php
$bas_template          = 'page-reglages-footer.php';
$bas_post_id           = matchcredit_reglages_post_id( $bas_template );
$footer_agence_adresse = matchcredit_reglages( 'bas_agence_adresse', $bas_template );
$footer_legal_links    = array(
	matchcredit_reglages( 'bas_lien_legal_1', $bas_template ),
	matchcredit_reglages( 'bas_lien_legal_2', $bas_template ),
	matchcredit_reglages( 'bas_lien_legal_3', $bas_template ),
);
?>
<footer class="footer">
	<div class="container">
		<div class="footer-top">
			<div>
				<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="mc-dot"></span>matchcrédit</a>
				<p class="footer-tag"><?php echo esc_html( matchcredit_reglages( 'bas_tagline', $bas_template ) ); ?></p>
				<div class="footer-quote"><?php echo nl2br( esc_html( matchcredit_reglages( 'bas_citation', $bas_template ) ) ); ?></div>
			</div>
			<div>
				<h4>Nos conseils</h4>
				<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => '', 'fallback_cb' => false ) ); ?>
			</div>
			<div>
				<h4>Agence de proximité</h4>
				<div class="footer-agence-card">
					<strong><?php echo esc_html( matchcredit_reglages( 'bas_agence_nom', $bas_template ) ); ?></strong>
					<div><?php echo nl2br( esc_html( $footer_agence_adresse ) ); ?><br><?php echo esc_html( matchcredit_reglages( 'bas_agence_telephone', $bas_template ) ); ?></div>
				</div>
				<ul>
					<li><?php matchcredit_link( 'bas_lien_rdv', '', 0, $bas_post_id ); ?></li>
				</ul>
			</div>
		</div>

		<div class="footer-huge">matchcrédit.</div>

		<div class="footer-bottom">
			<div>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php echo esc_html( matchcredit_reglages( 'bas_copyright', $bas_template ) ); ?></div>
			<div class="footer-legal-links">
				<?php foreach ( $footer_legal_links as $index => $lien ) : ?>
					<?php if ( ! empty( $lien['url'] ) ) : ?>
						<a href="<?php echo esc_url( $lien['url'] ); ?>"<?php echo ! empty( $lien['target'] ) ? ' target="' . esc_attr( $lien['target'] ) . '"' : ''; ?>><?php echo esc_html( $lien['title'] ); ?></a>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</footer>

<div class="legal-mention">
	<div class="container">
		<p><?php echo wp_kses_post( matchcredit_reglages( 'bas_mention_orias', $bas_template ) ); ?></p>
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>
