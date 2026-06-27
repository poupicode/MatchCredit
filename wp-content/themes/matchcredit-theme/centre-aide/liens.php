<section class="page-section page-section--white">
	<div class="container">
		<div class="section-intro section-intro--center">
			<div class="eyebrow"><?php the_field( 'aide_liens_eyebrow' ); ?></div>
			<h2 class="section-h section-h--sm"><?php matchcredit_title( 'aide_liens_titre' ); ?></h2>
		</div>

		<ul class="profile-edit-links profile-edit-links--center">
			<?php foreach ( array( 'aide_lien_1', 'aide_lien_2', 'aide_lien_3' ) as $lien_key ) :
				$lien = get_field( $lien_key );
				if ( ! $lien || empty( $lien['url'] ) ) continue;
				?>
				<li><a href="<?php echo esc_url( $lien['url'] ); ?>"><?php echo esc_html( $lien['title'] ); ?><span class="arrow-circle"><?php matchcredit_icon_arrow( 14 ); ?></span></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
