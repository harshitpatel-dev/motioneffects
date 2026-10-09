<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package motionedits
 */

?>

<?php if (is_singular()) : ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="row">
			<div class="blog-content">
				<header class="entry-header">
					<?php
					if (is_singular()) :
						the_title('<h1 class="entry-title d-none">', '</h1>');
						the_title('<h2 class="entry-title">', '</h2>');
					else :
						the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
					endif;

					if ('post' === get_post_type()) :
						motionedits_entry_author_meta();
					endif; ?>
				</header><!-- .entry-header -->

				<?php motionedits_post_thumbnail(); ?>

				<div class="entry-content">
					<?php
					the_content(
						sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'motionedits'),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							wp_kses_post(get_the_title())
						)
					);

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__('Pages:', 'motionedits'),
							'after'  => '</div>',
						)
					);
					?>

					<!-- Post Tags -->
					<?php
					$tags = get_the_tags();

					if ($tags) : ?>
						<div class="post-tags">
							<i class="bx bx-tag" aria-hidden="true"></i>
							<?php foreach ($tags as $tag) : ?>
								<a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="post-tag">
									<?php echo esc_html($tag->name); ?>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<!-- Related Posts -->
					<?php
					$current_post_id = get_the_ID();

					// Get tags of current post
					$tags = wp_get_post_tags($current_post_id);

					if ($tags) {

						$tag_ids = wp_list_pluck($tags, 'term_id');

						$args = [
							'post_type'      => 'post',
							'posts_per_page' => 3,
							'post__not_in'   => [$current_post_id], // exclude current post
							'tag__in'        => $tag_ids,
							'orderby'        => 'rand',
							'ignore_sticky_posts' => true,
						];

						$related_query = new WP_Query($args);

						if ($related_query->have_posts()) : ?>
							<div class="related-posts our_blogs_columWrap">
								<h3>Recommended Posts</h3>

								<div class="our-blogs">
									<div class="related-post-list our-blogs-content blogs-slider row">
										<?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
											<!-- <article class="related-post-item col-lg-4 col-sm-6">
												<a href="<?php the_permalink(); ?>">
													<?php if (has_post_thumbnail()) : ?>
														<?php the_post_thumbnail('medium'); ?>
													<?php endif; ?>
													<h4><?php the_title(); ?></h4>
												</a>
											</article> -->
											<div class="our-blog related-post-item col-lg-4 col-sm-6">
												<div class="content-wrap">
													<a href="<?php the_permalink(); ?>" class="img-link">

														<div class="images-contener">
															<div class="imgs">
																<?php if (has_post_thumbnail()): ?>
																	<?php the_post_thumbnail('full'); ?>
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
								</div>
							</div>
					<?php endif;

						wp_reset_postdata();
					}
					?>

				</div><!-- .entry-content -->

				<!-- <footer class="entry-footer">
				<?php motionedits_entry_footer(); ?>
			</footer> -->
				<!-- .entry-footer -->
			</div>
			<div class="contact-form">
				<div class="content">
					<h6 class="widget-title">Contact Form</h6>
					<div class="contact-section">
					<?php
					echo do_shortcode('[contact-form-7 id="30f58e9" title="Contact Form"]');
					?>
					</div>
					<div class="thankyou-section" style="display: none;">
    <h3 class="success-title">Thank you for showing interest in our services.</h3>
    <p class="modal-message">We have received your inquiry and excited to explore the opportunity of working together.</p>
    <p class="modal-message">Please allow us 24 hours to reply to your request. </p>
    <p class="modal-signature">Talk to you soon,<br><strong>Motion Edits</strong></p>
</div>
				</div>
				
<script>
    document.addEventListener('DOMContentLoaded', function() {



        document.addEventListener('wpcf7mailsent', function() {



            if (event.detail.status !== 'mail_sent') return;



            const contactSection = document.getElementsByClassName('contact-section')[0];
            const thankyouSection = document.getElementsByClassName('thankyou-section')[0];



            if (contactSection && thankyouSection) {
                thankyouSection.style.display = 'block';
                contactSection.style.display = 'none';
            }



            setTimeout(function() {
                const responseOutput = document.querySelector('.wpcf7-response-output');
                if (responseOutput && responseOutput.innerText.includes('Thank you for your message')) {
                    responseOutput.textContent = '';
                }



                const form = document.querySelector('.wpcf7 form');
                if (form && form.classList.contains('sent')) {
                    form.classList.remove('sent');
                    form.classList.add('init');
                }
            }, 1500);

            // REDIRECT TO THANK YOU PAGE
            setTimeout(function() {
                window.location.href = "/thank-you/";
            }, 2000); // delay for smooth UX



        }, false);



    });
</script>
			</div>
		</div>
	</article><!-- #post-<?php the_ID(); ?> -->
<?php else : ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('col-sm-6 col-lg-4'); ?>>
		<div class="content-wrap">
			<div class="images-container">
				<?php motionedits_post_thumbnail(); ?>

				<header class="entry-header content-title">
					<?php
					the_title('<h6 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h6>');
					if ('post' === get_post_type()) :
					?>
						<!-- <div class="entry-meta">
				<?php
						motionedits_posted_on();
						motionedits_posted_by();
				?>
			</div> -->
					<?php endif; ?>
				</header><!-- .entry-header -->
			</div>
		</div>
	</article><!-- #post-<?php the_ID(); ?> -->

<?php endif; ?>
