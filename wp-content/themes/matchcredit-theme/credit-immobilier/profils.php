<section class="page-section page-section--cream">
	<div class="container">
		<div class="profile-edit">
			<?php foreach ( array( 'cri_profil_1', 'cri_profil_2' ) as $profil_key ) :
				$profil = get_field( $profil_key );
				if ( ! $profil ) continue;
				?>
				<div class="profile-edit-col">
					<div class="num"><?php echo esc_html( $profil['numero'] ); ?></div>
					<h3><?php echo matchcredit_strip_title_p( $profil['titre'] ); ?></h3>
					<p><?php echo esc_html( $profil['texte'] ); ?></p>
					<ul class="profile-edit-links">
						<?php foreach ( array( 'lien_1', 'lien_2', 'lien_3', 'lien_4' ) as $lien_key ) :
							$lien = $profil[ $lien_key ] ?? null;
							if ( $lien && ! empty( $lien['url'] ) ) : ?>
								<li><a href="<?php echo esc_url( $lien['url'] ); ?>"><?php echo esc_html( $lien['title'] ); ?><span class="arrow-circle"><?php matchcredit_icon_arrow( 14 ); ?></span></a></li>
							<?php endif; endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
