<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package motionedits
 */

get_header();
?>

<main id="primary" class="site-main common-page-template-layout">

	<section class="error-404 not-found text-center motion_wrap">
		<div class="motion-containter">
			<header class="page-header">
<!-- 				<h4 class="page-title mb-2"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'motionedits'); ?></h4>
				<h6><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'motionedits'); ?></h6>
 -->
				<div class="redirect-message text-center mt-4">
    <p>
        You will be redirected to the <a href="<?php echo esc_url(home_url('/')); ?>">homepage</a> in
        <strong><span id="countdown">10</span></strong> seconds.
    </p>

    <p>
        <a class="button" href="<?php echo esc_url(home_url('/')); ?>">
            Go to Homepage Now
        </a>
    </p>
</div>
			</header><!-- .page-header -->

			<div class="page-content">
				<!-- <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'motionedits'); ?></p> -->

				<div class="widget_search">
					<?php
					get_search_form();
					// the_widget( 'WP_Widget_Recent_Posts' );
					?>
				</div>

				<div class="text-center" style="width: 100%;">
					<div class="four_zero_four_bg">
						<img src="<?php echo get_template_directory_uri(); ?>/images/404.svg" alt="">
					</div>
				</div>

				<!-- <div class="widget widget_categories">
					<h2 class="widget-title"><?php esc_html_e('Most Used Categories', 'motionedits'); ?></h2>
					<ul>
						<?php
						wp_list_categories(
							array(
								'orderby'    => 'count',
								'order'      => 'DESC',
								'show_count' => 1,
								'title_li'   => '',
								'number'     => 10,
							)
						);
						?>
					</ul> -->
			</div><!-- .widget -->

		</div><!-- .page-content -->
		</div>
	</section><!-- .error-404 -->

</main><!-- #main -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    let seconds = 10;
    const countdown = document.getElementById('countdown');

    const timer = setInterval(function () {
        seconds--;

        if (countdown) {
            countdown.textContent = seconds;
        }

        if (seconds <= 0) {
            clearInterval(timer);
            window.location.href = "<?php echo esc_url(home_url('/')); ?>";
        }
    }, 1000);
});
</script>

<?php
get_footer();
