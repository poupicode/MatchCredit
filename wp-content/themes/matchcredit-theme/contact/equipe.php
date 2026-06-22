<?php
$membres = get_posts( array(
	'post_type'      => 'membre_equipe',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order title',
	'order'          => 'ASC',
) );

if ( ! $membres ) {
	return;
}
?>
<section class="section-equipe">
	<div class="container">
		<div class="section-intro">
			<h2 class="section-h section-h--sm"><?php the_field( 'contact_equipe_titre' ); ?></h2>
			<p><?php the_field( 'contact_equipe_intro' ); ?></p>
		</div>

		<div class="equipe-grid">
			<?php foreach ( $membres as $membre ) : ?>
				<?php
				$nom    = get_the_title( $membre );
				$prenom = strtok( $nom, ' ' );
				$photo  = get_field( 'photo', $membre->ID );
				$role   = get_field( 'role', $membre->ID );
				$lien   = get_field( 'lien_rdv', $membre->ID );
				?>
				<div class="equipe-card">
					<?php if ( $photo ) : ?>
						<img src="<?php echo esc_url( $photo ); ?>" alt="<?php echo esc_attr( $nom ); ?>" class="equipe-photo">
					<?php endif; ?>
					<h3><?php echo esc_html( $nom ); ?></h3>
					<?php if ( $role ) : ?>
						<div class="equipe-role"><?php echo esc_html( $role ); ?></div>
					<?php endif; ?>
					<?php if ( $lien ) : ?>
						<a href="<?php echo esc_url( $lien ); ?>" class="btn-yellow equipe-cta">Prendre rendez-vous avec <?php echo esc_html( $prenom ); ?> <?php matchcredit_icon_arrow( 14 ); ?></a>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
