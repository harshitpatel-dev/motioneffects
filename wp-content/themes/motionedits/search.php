<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package motionedits
 */

get_header();
?>
<main id="primary" class="site-main common-page-template-layout top">

	<section class="motion-wrap">
		<div class="motion-container">

			<?php if (have_posts()) : ?>

				<header class="page-header">
					<div class="column-sub-desc-main-title">
						<div class="column-main-title">
							<h3 class="page-title text-center pb-0">
								<?php
								/* translators: %s: search query. */
								printf(esc_html__('Search Results for: %s', 'motionedits'), '<span>' . get_search_query() . '</span>');
								?>
							</h3>
						</div>
					</div>
				</header><!-- .page-header -->

				<div class="row">

					<?php
					/* Start the Loop */
					while (have_posts()) :
						the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part('template-parts/content', 'search');

					endwhile; ?>

				</div>

				<div class="pagination-blog">

					<?php if (function_exists("pagination")) {
						global $wp_query;
						pagination($wp_query->max_num_pages);
					} ?>

				</div>

			<?php else : ?>

				<?php get_template_part('template-parts/content', 'none'); ?>

			<?php endif; ?>

			<!-- Numbered pagination -->
			<?php
			function pagination($pages = '', $range = 4)
			{
				$showitems = ($range * 2) + 1;

				global $paged;
				if (empty($paged)) $paged = 1;

				if ($pages == '') {
					global $wp_query;
					$pages = $wp_query->max_num_pages;
					if (!$pages) {
						$pages = 1;
					}
				}

				if (1 != $pages) {
					echo "<div class=\"pagination\">";
					if ($paged > 2 && $paged > $range + 1 && $showitems < $pages) echo "<a class='first nav' href='" . get_pagenum_link(1) . "'>&laquo; First</a>";
					if ($paged > 1 && $showitems < $pages) echo "<a class='last nav' href='" . get_pagenum_link($paged - 1) . "'>&lsaquo; Previous</a>";

					for ($i = 1; $i <= $pages; $i++) {
						if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
							echo ($paged == $i) ? "<div class='rounded-pagination-current'><span class=\"current\">" . $i . "</span></div>" : "<div class='rounded-pagination-active'><a href='" . get_pagenum_link($i) . "' class=\"inactive\">" . $i . "</a></div>";
						}
					}

					if ($paged < $pages && $showitems < $pages) echo "<a class='next nav' href=\"" . get_pagenum_link($paged + 1) . "\">Next &rsaquo;</a>";
					if ($paged < $pages - 1 &&  $paged + $range - 1 < $pages && $showitems < $pages) echo "<a class='previous nav' href='" . get_pagenum_link($pages) . "'>Last &raquo;</a>";
					echo "</div>\n";
				}
			}
			?>

		</div>
	</section>

</main>
<?php
// get_sidebar();
get_footer();
