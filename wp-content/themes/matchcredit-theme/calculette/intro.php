<section class="calculette-hero">
	<div class="container">
		<div class="section-intro section-intro--calculette">
			<div class="eyebrow"><?php the_field( 'calculette_eyebrow' ); ?></div>
			<h1 class="section-h section-h--sm"><?php matchcredit_title( 'calculette_titre' ); ?></h1>
			<?php the_field( 'calculette_texte_intro' ); ?>
		</div>

		<div class="calculette-widget">
			<?php
			$outil = get_field( 'calculette_outil' );
			if ( $outil && function_exists( 'mc_tools_render' ) ) {
				echo mc_tools_render( $outil->post_name, array( 'echo' => false ) );
			}
			?>
		</div>
	</div>
</section>
