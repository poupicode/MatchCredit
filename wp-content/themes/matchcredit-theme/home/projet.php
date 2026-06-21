<section class="section-projet">
	<div class="container">
		<div class="section-intro section-intro--projet">
			<div class="eyebrow"><?php the_field( 'projet_etiquette' ); ?></div>
			<h2 class="section-h"><?php matchcredit_title( 'projet_titre' ); ?></h2>
			<p><?php the_field( 'projet_intro' ); ?></p>
		</div>

		<div class="profile-edit">
			<?php
			$projet_nb_profils = (int) get_field( 'projet_nb_profils' );
			foreach ( array_slice( array( 'profil_1', 'profil_2' ), 0, $projet_nb_profils ) as $profil_key ) :
				$profil = get_field( $profil_key );
				if ( ! $profil ) continue;
				?>
				<div class="profile-edit-col">
					<div class="num"><?php echo esc_html( $profil['numero'] ); ?></div>
					<h3><?php echo matchcredit_strip_title_p( $profil['titre'] ); ?></h3>
					<p><?php echo esc_html( $profil['texte'] ); ?></p>
					<ul class="profile-edit-links">
						<?php foreach ( array( 'lien_1', 'lien_2', 'lien_3' ) as $lien_key ) :
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
