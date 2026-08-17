<?php

/**
 * Hero lead form section — dynamic (ACF)
 * Layout uses Bootstrap grid. Right column renders Contact Form 7 shortcode.
 */

$show_elements = get_sub_field('show_elements');   // checkbox array
$custom_class = get_sub_field('custom_class');
$section_id = get_sub_field('section_id') ?? '';
$headline_text = get_sub_field('headline_text');
$headline_muted = get_sub_field('headline_muted');
$brand_tag = get_sub_field('brand_tag');
$form_card_title = get_sub_field('form_card_title');
$form_card_desc = get_sub_field('form_card_desc');
$card_slider = get_sub_field('card_slider');
$form_shortcode = get_sub_field('form_shortcode');
?>

<section id="<?php echo $section_id; ?>" class="contact-section hero-lead-form<?php echo $custom_class ? ' ' . esc_attr($custom_class) : ''; ?>">
	<div class="motion-container">
		<div class="row gx-0 align-items-center">

			<!-- LEFT: Text + Slider + Feature List -->
			<div class="col-lg-7 hero-left">
				<div class="ppc-wp-wrapper">

					<?php if (in_array('Headline', $show_elements) && ($headline_text || $headline_muted)): ?>
						<h1 class="ppc-headline-h1">
							<?php echo $headline_text; ?>
							<?php if ($headline_muted): ?>
								<span class="muted"><?php echo $headline_muted; ?></span>
							<?php endif; ?>
						</h1>
					<?php endif; ?>

					<?php if (in_array('Slider', $show_elements) && have_rows('slider_items')): ?>
						<div class="ppc-slider-area d-flex align-items-start">
							<h1 class="ppc-static-text"> </h1>
							<div class="ppc-slider-container" aria-hidden="false">
								<div class="ppc-slider-track" id="heroSliderTrack">
									<?php while (have_rows('slider_items')):
										the_row();
										$slider_text = get_sub_field('slider_text');
									?>
										<?php if ($slider_text): ?>
											<h1 class="ppc-slider-item"><?php echo esc_html($slider_text); ?></h1>
										<?php endif; ?>
									<?php endwhile; ?>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<?php if (in_array('Feature List', $show_elements) && ($brand_tag || have_rows('check_list'))): ?>
						<div class="feature-list">
							<?php if ($brand_tag): ?>
								<h2 class="brand-tag"><?php echo esc_html($brand_tag); ?></h2>
							<?php endif; ?>

							<?php if (have_rows('check_list')): ?>
								<ul class="check-list">
									<?php
									$index = 0;

									while (have_rows('check_list')):
										the_row();

										$icon = get_sub_field('item_icon');
										$item_title = get_sub_field('item_title');
										$item_text = get_sub_field('item_text');

									?>
										<li class="feature-item">
											<div class="feature-icon">
												<img src="<?php echo $icon['url']; ?>" alt="<?php echo $icon['alt']; ?>">
											</div>
											<div class="feature-content">
												<?php if ($item_title): ?>
													<h2 class="feature-title"><?php echo esc_html($item_title); ?></h2>
												<?php endif; ?>
												<?php if ($item_text): ?>
													<h2 class="feature-text"><?php echo esc_html($item_text); ?></h2>
												<?php endif; ?>
											</div>
										</li>
									<?php
										$index++;
									endwhile;
									?>
								</ul>
							<?php endif; ?>

						</div>
					<?php endif; ?>

					<?php if (in_array('Card Slider', $show_elements) && !empty($card_slider)): ?>
						<div class="specialize_columWrap vfx-card-slider">
							<div class="hero-card-slider specialize-container">
								<div class="specialize-content vfx-slider row">
									<?php foreach ($card_slider as $card):
										$icon = $card['icon'];
										$card_title = $card['title'];
										$icon_url = is_array($icon) ? ($icon['url'] ?? '') : $icon;
									?>
										<div class="specialize-card col-6 col-md-3">
											<div class="content-wrapper">
												<?php if (!empty($icon_url) && !empty($card_title)): ?>
													<div class="image-wrapper">
														<img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($card_title); ?>" fetchpriority="high" loading="lazy" />
													</div>
												<?php endif; ?>
												<?php if (!empty($card_title)): ?>
													<div class="title pb-0">
														<h5><?php echo esc_html($card_title); ?></h5>
													</div>
												<?php endif; ?>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					<?php endif; ?>

				</div>
			</div>

			<!-- RIGHT: Form Card -->
			<?php if (in_array('Form Card', $show_elements) && ($form_card_title || $form_shortcode)): ?>
				<div class="col-lg-5 hero-right">
					<div class="lead-form-card p-4">

						<?php if ($form_card_title): ?>
							<h4 class="title"><?php echo esc_html($form_card_title); ?></h4>
						<?php endif; ?>

						<?php if ($form_card_desc): ?>
							<p class="desc"><?php echo esc_html($form_card_desc); ?></p>
						<?php endif; ?>

						<?php if ($form_shortcode): ?>
							<div class="contact-form-wrapper mt-3">
								<?php echo do_shortcode($form_shortcode); ?>
							</div>
						<?php endif; ?>

					</div>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>

<?php if (false): ?>
	<script>
		// (function () {
		// 	// Vertical slider for hero lines
		// 	var track = document.getElementById('heroSliderTrack');
		// 	if (!track) return;
		// 	var items = track.querySelectorAll('.ppc-slider-item');
		// 	if (!items.length) return;
		// 	var total = items.length;
		// 	var current = 0;
		// 	var itemHeight = items[0].offsetHeight || 40;

		// 	function slide() {
		// 		current = (current + 1) % total;
		// 		track.style.transform = 'translateY(-' + (current * itemHeight) + 'px)';
		// 	}

		// 	// Recalculate on resize
		// 	window.addEventListener('resize', function () {
		// 		itemHeight = items[0].offsetHeight || 40;
		// 		track.style.transition = 'none';
		// 		track.style.transform = 'translateY(-' + (current * itemHeight) + 'px)';
		// 		// force reflow then restore transition
		// 		void track.offsetWidth;
		// 		track.style.transition = '';
		// 	});

		// 	track.style.transition = 'transform 0.5s cubic-bezier(.2,1,.3,1)';
		// 	setInterval(slide, 3000);
		// })();
	</script>
<?php endif; ?>