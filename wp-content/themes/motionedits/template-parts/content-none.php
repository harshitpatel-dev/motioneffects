<?php

/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package motionedits
 */

?>

<section class="no-results not-found text-center">
	<div class="motion-wrap">

		<header class="page-header">
			<h3 class="page-title"><?php esc_html_e('Nothing Found', 'motionedits'); ?></h1>
		</header><!-- .page-header -->

		<div class="page-content mt-2">
			<?php
			if (is_home() && current_user_can('publish_posts')) :

				printf(
					'<p>' . wp_kses(
						/* translators: 1: link to WP admin new post page. */
						__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'motionedits'),
						array(
							'a' => array(
								'href' => array(),
							),
						)
					) . '</p>',
					esc_url(admin_url('post-new.php'))
				);

			elseif (is_search()) :
			?>

				<h6><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'motionedits'); ?></h6>
				<div class="widget_search pb-0 mt-3">
					<?php get_search_form(); ?>
				</div>

			<?php else : ?>

				<h6><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'motionedits'); ?></h6>
				<div class="widget_search pb-2 mt-2">
					<?php get_search_form(); ?>
				</div>

			<?php endif; ?>
		</div><!-- .page-content -->
	</div>

</section><!-- .no-results -->