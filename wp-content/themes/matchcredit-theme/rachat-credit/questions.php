<section class="page-section page-section--cream">
	<div class="container">
		<div class="page-split-head">
			<div class="eyebrow"><?php the_field( 'rc_questions_eyebrow' ); ?></div>
		</div>
		<div class="page-split">
			<div class="page-split-aside page-split-aside--sticky">
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'rc_questions_titre' ); ?></h2>
			</div>

			<div class="page-split-content">
				<div class="faq-list">
					<?php
					$rc_questions_nb = (int) get_field( 'rc_questions_nb' );
					foreach ( array_slice( array( 'rc_question_1', 'rc_question_2', 'rc_question_3' ), 0, $rc_questions_nb ) as $i => $question_key ) :
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
	</div>
</section>
