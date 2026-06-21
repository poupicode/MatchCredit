<section class="faq">
	<div class="container">
		<div class="faq-grid">
			<div class="faq-side">
				<div class="eyebrow"><?php the_field( 'faq_etiquette' ); ?></div>
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'faq_titre' ); ?></h2>
				<p class="faq-intro"><?php the_field( 'faq_texte_intro' ); ?></p>
			</div>

			<div class="faq-list">
				<?php
				$faq_nb_questions = (int) get_field( 'faq_nb_questions' );
				foreach ( array_slice( array( 'question_1', 'question_2', 'question_3', 'question_4', 'question_5' ), 0, $faq_nb_questions ) as $i => $question_key ) :
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
