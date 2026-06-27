<section class="page-section page-section--cream">
	<div class="container">
		<div class="page-split-head">
			<div class="eyebrow"><?php the_field( 'cri_conseils_eyebrow' ); ?></div>
		</div>
		<div class="page-split">
			<div class="page-split-aside">
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'cri_conseils_titre' ); ?></h2>
			</div>
			<div class="page-split-content">
				<ul class="profile-edit-links">
					<?php foreach ( array( 'cri_conseil_1', 'cri_conseil_2', 'cri_conseil_3', 'cri_conseil_4' ) as $conseil_key ) :
						$lien = get_field( $conseil_key );
						if ( ! $lien || empty( $lien['url'] ) ) continue;
						?>
						<li><a href="<?php echo esc_url( $lien['url'] ); ?>"><?php echo esc_html( $lien['title'] ); ?><span class="arrow-circle"><?php matchcredit_icon_arrow( 14 ); ?></span></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>
