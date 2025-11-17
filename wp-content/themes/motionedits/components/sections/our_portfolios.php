<?php
    $custom_class  = get_sub_field( 'custom_class' );
	$show_elements = get_sub_field( 'show_elements' );
    $title  = get_sub_field( 'title' );
    $description  = get_sub_field( 'description' );
	$button_group = get_sub_field('buttons');
    $bg_color  = get_sub_field( 'bg_color' );
    $show_all_portfolios  = get_sub_field( 'show_all_portfolios' );
?>
<section class="our_portfolios_columWrap <?php echo esc_attr($custom_class); ?>" style="background-color: <?php echo $bg_color ?>;">
	<div class="motion-container">
		<?php if( in_array('Title',$show_elements)) : ?>
			<div class="column-sub-desc-main-title">
				<div class="row">
					<div class="column-main-title <?php if(in_array('Description',$show_elements)): ?>description<?php endif; ?>">
						<?php  if( in_array('Title',$show_elements)) : ?>
							<h3 class="title"><?php echo $title; ?></h3>
						<?php endif; ?>

						<?php  if( in_array('Description',$show_elements)) : ?>
							<div class="desc">
								<?php echo $description;?>
							</div>
						<?php endif; ?>
					</div>	
				</div>
			</div>
		<?php endif; ?>

		<?php if ( have_rows('portfolio_listing') ): 
			$i = 0;
		?>
			<div class="filters filter-button-group">
				<ul>
						<?php while ( have_rows('portfolio_listing') ): the_row(); 
							$category_name = get_sub_field('category_name');
							$active_class = ($i === 0) ? 'active' : '';
							$category_slug = strtolower( preg_replace('/[^a-zA-Z0-9]+/', '-', $category_name) );

							echo "<li data-filter='." . esc_attr($category_slug) . "' class='" . esc_attr($active_class) . "'><span>" . esc_html($category_name) . "</span></li>";
					?>
					<?php $i++; endwhile; ?>
				</ul>
			</div>

			<div class="our-portfolios">
				<div class="our-portfolios-content row justify-content-center grids">
					<?php while ( have_rows('portfolio_listing') ): the_row(); 
						$category_name = get_sub_field('category_name');
						$portfolios = get_sub_field('select_portfolio');
						$category_slug = strtolower( preg_replace('/[^a-zA-Z0-9]+/', '-', $category_name) );
					?>
							<?php if ( $portfolios ): ?>
								<?php foreach ( $portfolios as $portfolio ): ?>
								
								<?php
									$post_id = $portfolio->ID;
									$title = get_the_title($post_id);
									$feature_video = get_field('feature_video', $post_id);
									$thumbnail = get_the_post_thumbnail($post_id, 'full');
									$excerpt = get_the_excerpt($post_id);
								?>
								<div class="our-portfolio col-12 col-sm-6 col-md-6 col-lg-4 <?php echo trim($category_slug); ?> grid-item">
									<div class="content-wrap">
										<div class="images-contener">
											<div class="imgs">
													<?php if ( $thumbnail ) echo $thumbnail; ?>
											</div>
											<?php if ( $feature_video ) : ?>
												<span class="thumbnails-icon" data-bs-toggle="modal" data-bs-target="#portfolioVideoModal"
												data-video="<?php echo esc_url($feature_video); ?>"><span class="play-icon"><i class='bx bx-play'></i></span></span>
											<?php else : ?>
												<span class="thumbnails-icon disabled">
													<img src="<?php echo get_template_directory_uri(); ?>/images/play-icon-green.svg" alt="">
												</span>
											<?php endif; ?>
										</div>
										<div class="content">
											<h6 class="title"><?php echo esc_html($title); ?></h6>
											<div class="short-desc"><?php echo wp_kses_post($excerpt); ?></div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
							<?php endif; ?>
					<?php endwhile; ?>
				</div>
			
				<p class="no-portfolio-posts" style="display: none;">
					No Portfolios Found.
				</p>
			</div>
		<?php endif; ?>

		<!-- Buttons -->
		<div class="portfolios-buttons">
		<?php while (have_rows('buttons')) :  the_row();
			$button_link = get_sub_field('link');
			$link_url = $button_link['url'] ?? '#';
			$button_name = get_sub_field('label');
			$link_target = $button_link['target'] ?? '_self';
			$button_class = get_sub_field('btn_class');
		?>
			<?php if($button_name):?>
				<div class="buttons">
					<a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" class="btn <?php echo $button_class; ?>"><?php echo $button_name; ?></a>
				</div>
			<?php endif; ?>
		<?php endwhile; ?>
		</div>

	</div>
</section>
<!-- Common Portfolio Video Modal -->
<div class="modal fade" id="portfolioVideoModal" tabindex="-1" aria-labelledby="portfolioVideoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <button type="button" class="btnclose" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-x'></i></button>
     
        <div class="ratio ratio-16x9">
          <iframe id="portfolio-video-frame" src="" title="Portfolio Video" allow="autoplay; encrypted-media" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
    var $grid = $('.grids').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'fitRows'
    });

    /**
     * Equalize portfolio card heights per row
     */
    function equalizePortfolioHeights() {
        const $items = $('.grid-item:visible .content-wrap');
        if (!$items.length) return;

        // Reset heights
        $items.css('height', 'auto');

        let currentTop = 0;
        let rowItems = [];
        let maxHeight = 0;

        // Loop through each item
        $('.grid-item:visible').each(function() {
            const $item = $(this);
            const itemTop = $item.position().top;
            const $content = $item.find('.content-wrap');

            // If we’re on a new row
            if (itemTop !== currentTop && rowItems.length) {
                // Apply max height to the previous row
                $(rowItems).each(function() {
                    $(this).find('.content-wrap').height(maxHeight);
                });

                // Reset for new row
                rowItems = [];
                maxHeight = 0;
            }

            // Track the tallest height in the row
            const itemHeight = $content.outerHeight();
            if (itemHeight > maxHeight) maxHeight = itemHeight;

            // Collect current row’s items
            rowItems.push($item);

            // Update currentTop
            currentTop = itemTop;
        });

        // Apply height to the last row
        if (rowItems.length) {
            $(rowItems).each(function() {
                $(this).find('.content-wrap').height(maxHeight);
            });
        }
    }

    /**
     * Show/hide "No Posts Found" message
     */
    function checkVisiblePosts() {
        setTimeout(() => {
            if ($('.grid-item:visible').length === 0) {
                $('.no-portfolio-posts').show();
            } else {
                $('.no-portfolio-posts').hide();
            }
            equalizePortfolioHeights();
        }, 300);
    }

    /**
     * Isotope event bindings
     */
    $grid.on('layoutComplete arrangeComplete', function() {
        equalizePortfolioHeights();
    });

    // Filter click
    $('.filter-button-group').on('click', 'li', function() {
        const filterValue = $(this).attr('data-filter');
        $grid.isotope({ filter: filterValue });
        $('.filter-button-group li').removeClass('active');
        $(this).addClass('active');
        checkVisiblePosts();
    });

    // Apply default filter (first active)
    const $firstFilter = $('.filter-button-group li.active');
    if ($firstFilter.length) {
        const initialFilter = $firstFilter.attr('data-filter');
        $grid.isotope({ filter: initialFilter });
        $grid.on('arrangeComplete', checkVisiblePosts);
    }

    // Run equal height on load & resize
    $(window).on('load resize', equalizePortfolioHeights);

    /**
     * Video modal logic
     */
    const modal = $('#portfolioVideoModal');
    const iframe = $('#portfolio-video-frame');

    $('.thumbnails-icon').on('click', function() {
        const videoUrl = $(this).data('video');
        if (videoUrl) {
            let autoplayUrl = videoUrl;
            if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
                autoplayUrl = videoUrl.replace('watch?v=', 'embed/') + '?autoplay=1';
            } else if (videoUrl.includes('vimeo.com')) {
                autoplayUrl = videoUrl.includes('player.vimeo.com')
                    ? videoUrl + '?autoplay=1'
                    : videoUrl.replace('vimeo.com', 'player.vimeo.com/video') + '?autoplay=1';
            }
            iframe.attr('src', autoplayUrl);
			iframe[0].contentWindow?.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
        }
    });

    modal.on('hidden.bs.modal', function() {
        iframe.attr('src', '');
    });
});
</script>
