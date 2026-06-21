<div class="partners-edit">
	<div class="container">
		<div class="partners-edit-row">
			<?php $orias_logo = get_field( 'orias_logo' ); ?>
			<?php if ( $orias_logo ) : ?>
				<img src="<?php echo esc_url( $orias_logo ); ?>" alt="ORIAS" class="partner-logo">
			<?php endif; ?>
			<span class="partner-block">
				<strong><?php the_field( 'orias_texte' ); ?></strong>
				<?php matchcredit_link( 'orias_lien', 'partner-link' ); ?>
			</span>

			<?php $afib_logo = get_field( 'afib_logo' ); ?>
			<?php if ( $afib_logo ) : ?>
				<img src="<?php echo esc_url( $afib_logo ); ?>" alt="AFIB" class="partner-logo">
			<?php endif; ?>
			<span class="partner-block">
				<strong><?php the_field( 'afib_texte' ); ?></strong>
				<?php matchcredit_link( 'afib_lien', 'partner-link' ); ?>
			</span>
		</div>
	</div>
</div>
