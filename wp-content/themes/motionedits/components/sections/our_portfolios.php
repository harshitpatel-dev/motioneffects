<?php
$show_elements = get_sub_field('show_elements');
$title = get_sub_field('title');
$description = get_sub_field('description');
$show_packages_button = get_sub_field('show_packages_button');
$button_group = get_sub_field('buttons');
$portfolio_categories = get_sub_field('portfolio_categories');

$bg_color = get_sub_field('bg_color');
$custom_class = get_sub_field('custom_class');
?>

<section class="our_portfolios_columWrap <?php echo esc_attr($custom_class); ?>"
    style="background-color: <?php echo esc_attr($bg_color); ?>" id="portfolio">
    <div class="motion-container">
        <?php if (in_array('Title', $show_elements)): ?>
            <div class="column-sub-desc-main-title">
                <div class="row">
                    <div
                        class="column-main-title <?php if (in_array('Description', $show_elements)): ?>description<?php endif; ?>">
                        <?php if (in_array('Title', $show_elements)): ?>
                            <h3 class="title"><?php echo $title; ?></h3>
                        <?php endif; ?>

                        <?php if (in_array('Description', $show_elements)): ?>
                            <div class="desc">
                                <?php echo $description; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if (!empty($portfolio_categories)): ?>

            <div class="filters filter-button-group nav-tabs-wrapper">
                <ul class="nav nav-tabs justify-content-center filter-button-group" id="portfolioTabs" role="tablist">
                    <?php foreach ($portfolio_categories as $index => $cat):
                        $term = $cat['main_category'];
                        if (!$term)
                            continue;
                        $active = ($index === 0) ? 'active' : '';
                        $slug = $term->slug;
                        ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo esc_attr($active); ?>" id="<?php echo esc_attr($slug); ?>-tab"
                                data-bs-toggle="tab" data-category="<?php echo esc_attr($term->slug); ?>" data-bs-target="#<?php echo esc_attr($slug); ?>-pane" type="button"
                                role="tab" aria-controls="<?php echo esc_attr($slug); ?>-pane"
                                aria-selected="<?php echo ($index === 0) ? 'true' : 'false'; ?>">
                                <?php echo esc_html($term->name); ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="our-portfolios">
                <div class="tab-content">
                    <?php foreach ($portfolio_categories as $index => $cat):
                        $term = $cat['main_category'];
                        if (!$term)
                            continue;
                        $slug = $term->slug;
                        $featured = $cat['featured_videos'];
						$is_reels = $cat['is_reels'];
					    $is_reel_class = $is_reels ? 'col-12 col-sm-6 col-md-4 col-lg-3 reels-videos' : 'col-12 col-sm-6 col-md-6 col-lg-4';

                        $pane_active = ($index === 0) ? 'show active' : '';
                        ?>
                        <div class="tab-pane fade <?php echo esc_attr($pane_active); ?>"
                            id="<?php echo esc_attr($slug); ?>-pane" role="tabpanel"
                            aria-labelledby="<?php echo esc_attr($slug); ?>-tab">
							<div class="portfolio-block">
								<div class="our-portfolios-content row justify-content-center grids portfolio-group">
									<?php if (!empty($featured)): ?>
										<?php foreach ($featured as $post):
											setup_postdata($post);
											$video = get_field('feature_video', $post->ID);
											?>
											<div class="our-portfolio <?php echo $is_reel_class; ?> grid-item <?php echo esc_attr($slug); ?>"
												data-category="<?php echo esc_attr($slug); ?>"
												data-aos="">
												<div class="content-wrap">
													<div class="images-contener">
														<div class="imgs">
															<?php
																echo get_the_post_thumbnail(
																	$post->ID,
																	'medium',
																	[
																		'loading'  => 'lazy',
																		'decoding' => 'async',
																		'class'    => 'img-fluid'
																	]
																);
															?>
														</div>
														<?php if ($video): ?>
															<span class="thumbnails-icon" data-bs-toggle="modal"
																data-bs-target="#portfolioVideoModal"
																data-video="<?php echo esc_url($video); ?>">
																<span class="play-icon"><i class="bx bx-play"></i></span>
															</span>
														<?php endif; ?>
													</div>

													<div class="content">
														<h6 class="title"><?php echo esc_html(get_the_title($post)); ?></h6>
													</div>
												</div>
											</div>
										<?php endforeach;
										wp_reset_postdata(); ?>
									<?php endif; ?>
									<?php if (!empty($featured) || (in_array('Button', $show_elements) && !empty($cat['button']))): ?>
										<div class="load-more-wrap text-center mt-4 d-flex justify-content-center align-items-center flex-wrap gap-3">
                                            <?php if (!empty($featured) && count($featured) > 6): ?>
                                                <button class="btn btn-primary load-more-btn"
                                                    data-category="<?php echo esc_attr($slug); ?>">
                                                    Load More
                                                </button>
                                            <?php endif; ?>
                                            <?php if ($show_packages_button): ?>
                                                <a href="#packages" class="btn btn-primary">
                                                    View Pricing
                                                </a>
                                            <?php endif; ?>
                                            <?php if (in_array('Button', $show_elements) && !empty($cat['button'])):
                                                $cat_button = $cat['button'];
                                                $button_label = isset($cat_button['label']) && !empty($cat_button['label']) ? $cat_button['label'] : "View Portfolio";
                                                $button_link = $cat_button['link'];
                                                $link_url = $button_link['url'] ?? '#';
                                                $link_target = $button_link['target'] ?? '_self';
                                                ?>
                                                <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"
                                                    class="btn btn-primary"><?php echo esc_html($button_label); ?></a>
                                            <?php endif; ?>
										</div>
									<?php endif; ?>
								</div>
                            </div>

                            <?php if (!in_array('Button', $show_elements) && !empty($cat['sub-categories'])): ?>
                                <?php foreach ($cat['sub-categories'] as $sub): ?>
                                    <div class="sub-category-section mt-4">
                                        <div
                                            class="column-main-title col-12 portfolio-section-title grid-item <?php echo esc_attr($slug); ?> text-center mb-3">
                                            <h3 class="title"><?php echo esc_html($sub['title']); ?></h3>
                                        </div>
										
										<div class="portfolio-block">
											<div class="row justify-content-center grids portfolio-group">
												<?php
												$is_reels_class = $sub['is_reels'] ? 'col-sm-6 col-md-4 col-lg-3 reels-videos' : 'col-sm-6 col-md-6 col-lg-4';
												foreach ($sub['videos'] as $post):
													setup_postdata($post);
													$video = get_field('feature_video', $post->ID);
													?>
													<div class="our-portfolio col-12 <?php echo esc_attr($is_reels_class); ?> grid-item <?php echo esc_attr($slug); ?>"
														data-aos="">
														<div class="content-wrap">
															<div class="images-contener">
																<div class="imgs">
																	<?php echo get_the_post_thumbnail($post->ID, 'full'); ?>
																</div>
																<?php if ($video): ?>
																	<span class="thumbnails-icon" data-bs-toggle="modal"
																		data-bs-target="#portfolioVideoModal"
																		data-video="<?php echo esc_url($video); ?>">
																		<span class="play-icon"><i class="bx bx-play"></i></span>
																	</span>
																<?php endif; ?>
															</div>

															<div class="content">
																<h6 class="title"><?php echo esc_html(get_the_title($post)); ?></h6>
															</div>
														</div>
													</div>
												<?php endforeach;
												wp_reset_postdata(); ?>
											</div>

                                            <?php if (!empty($sub['videos']) && count($sub['videos']) > 6): ?>
                                                <div class="load-more-wrap text-center mt-2 mb-2">
                                                    <button class="btn btn-primary load-more-btn">Load More</button>
                                                </div>
                                            <?php endif; ?>
										</div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>
                </div>


            </div>
        <?php endif; ?>
    </div>

    <div class="modal fade" id="portfolioVideoModal" tabindex="-1" aria-labelledby="portfolioVideoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <button type="button" class="btnclose" data-bs-dismiss="modal" aria-label="Close"><i
                        class='bx bx-x'></i></button>

                <div class="ratio ratio-16x9">
                    <iframe id="portfolio-video-frame" src="" title="Portfolio Video" allow="autoplay; encrypted-media"
                        frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <script>
jQuery(function ($) {
    let loading = false;

    /* -----------------------------
     Stagger animation
    ----------------------------- */
    function animatePortfolioItems($pane) {
        if (!$pane?.length) return;

        $pane.find('.grid-item:visible').each(function (i) {
            this.classList.remove('stagger-animate');
            this.style.animationDelay = '0ms';

            void this.offsetWidth; // force reflow

            this.style.animationDelay = (i * 100) + 'ms';
            this.classList.add('stagger-animate');
        });
    }

    /* -----------------------------
     Equal card heights (per row)
    ----------------------------- */
    function equalizePortfolioHeights() {
        const $items = $('.our-portfolio:visible');
        if (!$items.length) return;

        let currentTop = null;
        let maxHeight = 0;
        let rowItems = [];

        $items.find('.content-wrap').css('height', 'auto');

        $items.each(function () {
            const $item = $(this);
            const top = Math.round($item.position().top);
            const $content = $item.find('.content-wrap');
            const height = $content.outerHeight();

            if (currentTop !== null && top !== currentTop) {
                rowItems.forEach(el => el.find('.content-wrap').height(maxHeight));
                rowItems = [];
                maxHeight = 0;
            }

            maxHeight = Math.max(maxHeight, height);
            rowItems.push($item);
            currentTop = top;
        });

        rowItems.forEach(el => el.find('.content-wrap').height(maxHeight));
    }

    /* -----------------------------
     Show / hide empty message
    ----------------------------- */
    function checkVisiblePosts() {
        const hasItems = $('.our-portfolio:visible').length > 0;
        $('.no-portfolio-posts').toggle(!hasItems);
        equalizePortfolioHeights();
    }

    /* -----------------------------
         LOAD MORE LOGIC
        ----------------------------- */
        function initPortfolioLoadMore() {
            $('.tab-pane').each(function() {
                const $pane = $(this);
                const $items = $pane.find('.our-portfolio');
                const $btn = $pane.find('.load-more-btn');

                // ✅ DETECT REELS TAB
                const isReelTab = $items.first().hasClass('reels-videos');

                // ✅ SET COUNT
                const visibleCount = isReelTab ? 8 : 6;

                // RESET
                $items.hide();
                $items.slice(0, visibleCount).show();

                // BUTTON VISIBILITY
                if ($items.length > visibleCount) {
                    $btn.show();
                } else {
                    $btn.hide();
                }

                $btn.off('click');

                $btn.on('click', function() {
                    const visible = $items.filter(':visible').length;

                    // ✅ LOAD NEXT BASED ON TYPE
                    const next = $items.slice(visible, visible + visibleCount);

                    next.each(function(i) {
                        this.classList.remove('stagger-animate');
                        this.style.animationDelay = '0ms';

                        void this.offsetWidth;

                        this.style.animationDelay = (i * 100) + 'ms';

                        $(this).fadeIn(200, function() {
                            this.classList.add('stagger-animate');
                        });
                    });

                    // HIDE BUTTON WHEN DONE
                    if ($items.filter(':visible').length >= $items.length) {
                        $btn.hide();
                    }

                    equalizePortfolioHeights();
                });
            });
        }

    /* -----------------------------
     Bootstrap tab change
    ----------------------------- */
    $('#portfolioTabs button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        const $pane = $($(e.target).data('bs-target'));

        initPortfolioLoadMore();
        animatePortfolioItems($pane);
        checkVisiblePosts();

        // AOS.refreshHard();
        if (typeof AOS !== "undefined") {
            AOS.refreshHard();
        }
    });

    /* -----------------------------
     Initial load & resize
    ----------------------------- */
    $(window).on('load', function () {
        initPortfolioLoadMore();
        animatePortfolioItems($('.tab-pane.show.active'));
        checkVisiblePosts();

        // AOS.refreshHard();
        if (typeof AOS !== "undefined") {
            AOS.refreshHard();
        }
    });

    $(window).on('resize', equalizePortfolioHeights);

    /* -----------------------------
        Video modal + browser back handling
        ----------------------------- */
        const $modal = $('#portfolioVideoModal');
        const $iframeContainer = $modal.find('.ratio');
        let isModalOpen = false;
        let isClosing = false;

        /* Create fresh iframe each time */
        function createFreshIframe(url) {
            // Remove old iframe completely
            $iframeContainer.find('iframe').remove();

            console.log('Creating iframe with URL:', url);

            // Create new iframe
            const $newIframe = $('<iframe>', {
                id: 'portfolio-video-frame',
                src: url,
                title: 'Portfolio Video',
                allow: 'autoplay; encrypted-media',
                frameborder: '0',
                allowfullscreen: true
            });

            // Add to container (before error message div)
            $iframeContainer.prepend($newIframe);
        }

        /* Open modal → load video */
        $('#portfolio').on('click', '.thumbnails-icon', function () {
            let url = $(this).data('video');
            if (!url) return;

            // Hide any error message
            $('#video-error-message').hide();

            // Convert URL to embed format with autoplay
            if (url.includes('youtube.com/watch')) {
                url = url.replace('watch?v=', 'embed/') + '?autoplay=1';
            } else if (url.includes('youtu.be/')) {
                url = url.replace('youtu.be/', 'youtube.com/embed/') + '?autoplay=1';
            } else if (url.includes('vimeo.com') && !url.includes('player.vimeo.com')) {
                url = url.replace('vimeo.com/', 'player.vimeo.com/video/') + '?autoplay=1';
            } else if (url.includes('player.vimeo.com') && !url.includes('autoplay')) {
                url = url + (url.includes('?') ? '&' : '?') + 'autoplay=1';
            }else if (url.includes('youtube.com/embed') && !url.includes('autoplay')) {
                url = url + (url.includes('?') ? '&' : '?') + 'autoplay=1';
            }

            console.log('Opening modal with video URL:', url);
            // Create fresh iframe with new URL
            createFreshIframe(url);
        });

        /* Modal opened → push history */
        $modal.on('shown.bs.modal', function () {
            if (!isModalOpen) {
                history.pushState({ portfolioModal: true }, '');
                isModalOpen = true;
            }
            isClosing = false;
        });

        /* Modal closed → cleanup */
        $modal.on('hidden.bs.modal', function () {
            const wasOpen = isModalOpen;
            const wasClosedByBack = isClosing;

            // Reset state immediately
            isModalOpen = false;
            isClosing = false;

            // Clear iframe src to stop video
            $iframeContainer.find('iframe').attr('src', 'about:blank');

            // If modal was open and NOT closed by back button, clean up history
            if (wasOpen && !wasClosedByBack) {
                setTimeout(function() {
                    history.back();
                }, 10);
            }
        });

        /* Browser back → close modal */
        window.addEventListener('popstate', function (event) {
            if (isModalOpen && !isClosing) {
                isClosing = true;
                const modalInstance = bootstrap.Modal.getInstance($modal[0]);
                if (modalInstance) {
                    modalInstance.hide();
                }
            }
        });

});
jQuery(function ($) {

    const mobileBreakpoint = 768;

    function initMobileSlider($container) {
        if (!$container.length) return;

        if ($(window).width() < mobileBreakpoint) {
            if (!$container.hasClass('slick-initialized')) {
                $container.slick({
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    dots: true,
                    arrows: true,
                    infinite: false,
//                     adaptiveHeight: true,
                    adaptiveHeight: false,
                    responsive: [
                        {
                            breakpoint: 576,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                            }
                        }
                    ]
                });
            }
        } else {
            if ($container.hasClass('slick-initialized')) {
                $container.slick('unslick');
            }
        }
    }

    // Initialize sliders for ALL tabs, not just the active one
    function initAllTabsSliders() {
        // Loop through ALL tab panes (not just active)
        $('.tab-pane').each(function () {
            const $pane = $(this);
            
            // Initialize main portfolio sliders
            $pane.find('.our-portfolios-content.grids').each(function () {
                initMobileSlider($(this));
            });

            // Initialize sub-category sliders
            $pane.find('.sub-category-section .grids').each(function () {
                initMobileSlider($(this));
            });
        });

        // Refresh AOS after all sliders are initialized
        setTimeout(function() {
            if (typeof AOS !== 'undefined') {
                AOS.refreshHard();
            }
        }, 100);
    }

    // Refresh slider when tab is shown (for proper height calculation)
    $('#portfolioTabs button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        const $targetPane = $($(e.target).data('bs-target'));
        
        // Refresh slick sliders in the newly shown tab
        $targetPane.find('.slick-initialized').each(function () {
            $(this).slick('setPosition');
        });

        // Refresh AOS after tab change and slider position update
        setTimeout(function() {
            if (typeof AOS !== 'undefined') {
                AOS.refreshHard();
            }
        }, 150);
    });

    /* On load - initialize ALL tabs */
    $(window).on('load', function () {
        initAllTabsSliders();
    });

    /* On resize - reinitialize all */
    $(window).on('resize', function () {
        initAllTabsSliders();
    });

});
</script> -->
<style>
#portfolio .grid-item {
    opacity: 0;
    transform: translateY(16px);
}

#portfolio .grid-item.stagger-animate {
    animation: portfolioFade 0.5s ease forwards;
}



@media (max-width: 767px) {
    #portfolio .our-portfolios-content.grids,
    #portfolio .sub-category-section .grids {
        display: block; /* Slick requires block */
    }

    #portfolio .our-portfolio {
        padding: 0 10px;
    }
}

@keyframes portfolioFade {
    from {
        opacity: 0;
        transform: translateY(16px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>