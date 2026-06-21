<section class="page-section page-section--cream">
	<div class="container">
		<div class="page-split-head">
			<div class="eyebrow"><?php the_field( 'rt_arbitrage_eyebrow' ); ?></div>
		</div>
		<div class="page-split">
			<div class="page-split-aside page-split-aside--sticky">
				<h2 class="section-h section-h--sm"><?php matchcredit_title( 'rt_arbitrage_titre' ); ?></h2>
			</div>

			<div class="page-split-content">
				<div class="faq-list">
					<?php foreach ( array( 'rt_arbitrage_1', 'rt_arbitrage_2', 'rt_arbitrage_3' ) as $i => $arbitrage_key ) :
						$arbitrage = get_field( $arbitrage_key );
						if ( ! $arbitrage ) continue;
						$open = $i === 0 ? ' open' : '';
						?>
						<div class="faq-item<?php echo esc_attr( $open ); ?>">
							<button class="faq-q">
								<?php echo esc_html( $arbitrage['question'] ); ?>
								<span class="faq-toggle"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"></path></svg></span>
							</button>
							<div class="faq-a"><div class="faq-a-inner"><?php echo esc_html( $arbitrage['reponse'] ); ?></div></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
