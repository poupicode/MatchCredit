<section class="page-section page-section--cream">
	<div class="container">
		<div class="section-intro section-intro--center">
			<div class="eyebrow"><?php the_field( 'aide_faq_eyebrow' ); ?></div>
			<h2 class="section-h section-h--sm"><?php matchcredit_title( 'aide_faq_titre' ); ?></h2>
		</div>

		<div class="page-accordion page-accordion--center">
			<div class="faq-list">
				<?php
				$aide_faq_nb = (int) get_field( 'aide_faq_nb' );
				foreach ( array_slice( array( 'aide_question_1', 'aide_question_2', 'aide_question_3', 'aide_question_4', 'aide_question_5', 'aide_question_6' ), 0, $aide_faq_nb ) as $i => $question_key ) :
					$question = get_field( $question_key );
					if ( ! $question ) continue;
					$open = $i === 0 ? ' open' : '';
					?>
					<div class="faq-item<?php echo esc_attr( $open ); ?>">
						<button class="faq-q">
							<?php echo esc_html( $question['question'] ); ?>
							<span class="faq-toggle"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"></path></svg></span>
						</button>
						<div class="faq-a"><div class="faq-a-inner"><?php echo esc_html( $question['reponse'] ); ?></div></div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
