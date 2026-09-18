<?php
global $animation_blog_delay;
$animation_blog_delay = 0;

$custom_class = get_sub_field('custom_class');
$show_elements = get_sub_field('show_elements');
$title = get_sub_field('title');
$description = get_sub_field('description');
$bg_color = get_sub_field('bg_color');
$show_options = get_sub_field('show_options');
$show_all_blogs = get_sub_field('show_all_blogs'); // true/false
$selected_tag   = get_sub_field('page_blog');
$animation_delay = 0;

$is_author_mode = ($show_options == "Author");
$author_id      = $is_author_mode ? (is_author() ? get_queried_object_id() : (int) get_the_author_meta('ID')) : 0;

// Author mode always lists every one of that author's posts, paginated,
// the same as "Show All Blogs" — it doesn't need the toggle checked too.
$is_paginated_grid = $show_all_blogs || $is_author_mode;

if ($is_paginated_grid) {
	$custom_class .= " all_blogs";
}
?>

<section class="our_blogs_columWrap <?php echo esc_attr($custom_class); ?> "
	style="background-color: <?php echo esc_attr($bg_color); ?>;">
	<div class="motion-container">

		<!-- TITLE + DESCRIPTION -->
		<?php if (in_array('Title', $show_elements)): ?>
			<div class="column-sub-desc-main-title" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>"
				data-aos-duration="1000">

				<?php $animation_delay += 200; ?>

				<div class="row">
					<div
						class="column-main-title <?php echo in_array('Description', $show_elements) ? 'description' : ''; ?>">
						<h3 class="title"><?php echo esc_html($title); ?></h3>

						<?php if (in_array('Description', $show_elements)): ?>
							<div class="desc"><?php echo wp_kses_post($description); ?></div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>


		<!-- BLOGS LIST -->
		<div class="our-blogs">

			<?php
			global $paged;
			$paged = get_query_var('paged') ? get_query_var('paged') : 1;

// 			$args = [
// 				'post_type' => 'post',
// 				'post_status' => 'publish',
// 				'order' => 'DESC',
// 				'posts_per_page' => $show_all_blogs ? 12 : 3,
// 				'paged' => $paged,
// 			];
            if ($is_author_mode) {
				// Every post by the author being viewed, paginated 6 at a time.
				$args = [
					'post_type'      => 'post',
					'post_status'    => 'publish',
					'order'          => 'DESC',
					'posts_per_page' => 6,
					'paged'          => $paged,
					'author'         => $author_id,
				];
			} elseif ($show_all_blogs) {
				$args = [
					'post_type' => 'post',
					'post_status' => 'publish',
					'order' => 'DESC',
					'posts_per_page' => 12,
					'paged' => $paged,
				];
			} else {
			if($show_options == "Latest Blog") {
				$args = [
					'post_type' => 'post',
					'post_status' => 'publish',
					'order' => 'DESC',
					'posts_per_page' => 3,
					'paged' => $paged,
				];
			} elseif ($show_options == "Page Blog"){
				// $args = [
				// 	'post_type' => 'post',
				// 	'taxonomy' => 'post_tag',
				// 	'terms'    => $selected_tag->term_id,
				// 	'post_status' => 'publish',
				// 	'order' => 'DESC',
				// 	'posts_per_page' => 3,
				// 	'paged' => $paged,
				// ];
				$args = [
					'post_type'      => 'post',
					'post_status'    => 'publish',
					'order'          => 'DESC',
					'posts_per_page' => 3,
					'paged'          => $paged,
					'tax_query'      => [
						[
							'taxonomy' => 'post_tag',
							'field'    => 'term_id',
							'terms'    => $selected_tag->term_id,
						],
					],
				];
			} else {
				$args = [
					'post_type' => 'post',
					'post_status' => 'publish',
					'order' => 'DESC',
					'posts_per_page' => 12,
					'paged' => $paged,
				];
			}
				}

			// exclude current post in single
			if (is_singular('post')) {
				$args['post__not_in'] = [get_the_ID()];
			}

			$blogsposts = new WP_Query($args);
			?>

			<?php if ($blogsposts->have_posts()): ?>
				<?php if ($is_paginated_grid): ?>
			<div class="our-blogscontent"
				data-page="1"
				data-max="<?php echo esc_attr($blogsposts->max_num_pages); ?>"
				data-author-id="<?php echo esc_attr($author_id); ?>"
				data-per-page="<?php echo $is_author_mode ? 6 : 12; ?>">
		<?php else : ?>
			<div class="our-blogscontent">
				<?php endif; ?>

				<div class="our-blogs-content row justify-content-center <?php echo !$is_paginated_grid ? 'blogs-slider' : ''; ?> ">

					<?php while ($blogsposts->have_posts()):
						$blogsposts->the_post(); ?>

						<div class="our-blog <?php echo !$is_paginated_grid ? 'col-md-4 col-lg-4' : 'col-lg-4 col-sm-6'; ?>"
							data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">

							<?php $animation_delay += 200; ?>
							<?php $animation_blog_delay += 200; ?>
							<div class="content-wrap">
								<a href="<?php the_permalink(); ?>" class="img-link">

									<div class="images-contener">
										<div class="imgs">
											<?php if (has_post_thumbnail()): ?>
												<?php the_post_thumbnail(
  'medium_large',
  [
    'loading' => 'lazy',
    'decoding' => 'async'
  ]
); ?>
											<?php else: ?>
												<img src="<?php echo esc_url(get_template_directory_uri() . '/images/default-image.png'); ?>"
													alt="Coming soon">
											<?php endif; ?>
										</div>

										<div class="meta">
											<span class="date"><?php echo get_the_date('F d, Y'); ?></span>
										</div>
									</div>

									<div class="content">
										<h6 class="title"><?php the_title(); ?></h6>

										<div class="short-desc"><?php the_excerpt(); ?></div>

										<div class="buttons">
											<span class="btn-readmore">Read More</span>
										</div>
									</div>

								</a>
							</div>

						</div>
					<?php endwhile; ?>
				</div>

			<?php endif; ?>

			<?php wp_reset_postdata(); ?>

			<!-- PAGINATION ONLY WHEN show_all_blogs / Author mode -->
			<?php if ($is_paginated_grid): ?>
				<!-- Loading indicator for infinite scroll -->
				<div class="blog-loader" style="display:none;">
					<div class="custom-loader">
						<div class="blue-spinner"></div>
					</div>
				</div>
			<?php endif; ?>

		</div>


		<!-- BUTTONS -->
		<?php if (in_array('Button', $show_elements)): ?>
			<div class="blogs-buttons" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>"
				data-aos-duration="1000">

				<?php $animation_delay += 200; ?>

				<?php while (have_rows('buttons')):
					the_row();
					$button_label = get_sub_field('label');
					$button_link = get_sub_field('link');
					$button_class = get_sub_field('btn_class');
					?>

					<?php if ($button_label): ?>
						<div class="buttons">
							<a href="<?php echo esc_url($button_link); ?>" class="btn <?php echo esc_attr($button_class); ?>">
								<?php echo esc_html($button_label); ?>
							</a>
						</div>
					<?php endif; ?>

				<?php endwhile; ?>
			</div>
		<?php endif; ?>

	</div>
</section>

<?php if (!$is_paginated_grid): ?>
	<script>
		jQuery(function ($) {

			// Slick only in "3 blogs" mode
			if ($('.blogs-slider').length && $.fn.slick) {

				$('.blogs-slider').slick({
					infinite: false,
					slidesToShow: 3,
					slidesToScroll: 1,
					dots: false,
					arrows: false,
					autoplay: false,
adaptiveHeight: false,
					responsive: [
						{ breakpoint: 1199, settings: { slidesToShow: 2, dots: true ,arrows: true } },
						{ breakpoint: 767, settings: { slidesToShow: 2, dots: true ,arrows: true } },
						{ breakpoint: 576, settings: { slidesToShow: 1, dots: true ,arrows: true } }
					]
				});
			}

		});
	</script>
<?php endif; ?>

<?php if ($is_paginated_grid): ?>
	<script type="text/javascript">

		jQuery(document).ready(function($) {
			let loading = false;

			jQuery(window).on('scroll', function(){

				if(loading) return;

				let container = $('.our-blogscontent');
				let page = parseInt(container.attr('data-page'));
				let max = parseInt(container.attr('data-max'));

				if(page >= max) return;

				if($(window).scrollTop() + $(window).height() >= $(document).height() - 200){

					loading = true;
					$('.blog-loader').css('display', 'flex');
					$.ajax({
						url: "<?php echo admin_url('admin-ajax.php'); ?>",
						type: "POST",
						data: {
							action: "load_more_blogs",
							page: page + 1,
							author_id: container.attr('data-author-id'),
							per_page: container.attr('data-per-page')
						},
						success: function(response){
							$('.our-blogs-content').append(response);
							container.attr('data-page', page + 1);

							// Important for NitroPack + AJAX
							setTimeout(function(){
								if (typeof AOS !== 'undefined') {
									AOS.refreshHard();
								}
							}, 300);
							loading = false;
							$('.blog-loader').hide();
						}
					});
				}

			});
		});
	</script>
<?php endif; ?>