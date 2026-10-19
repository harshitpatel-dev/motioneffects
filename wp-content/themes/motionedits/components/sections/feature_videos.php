<?php
$section_id = 'featured-section-' . get_row_index();
$show_elements = get_sub_field('show_elements');
$title = get_sub_field('title');
$description = get_sub_field('description');
$video_items = get_sub_field('video_items');
$show_slider = get_sub_field('show_slider');
$bg_color = get_sub_field('bg_color');
$custom_class = get_sub_field('custom_class');
// animation delay counter (ms)
$animation_delay = 0;
?>
<section class="featured_columWrap <?php echo esc_attr($custom_class); ?>"
    style="background-color: <?php echo esc_attr($bg_color); ?>;" id="<?php echo esc_attr($section_id); ?>">
    <div class="motion-container">

        <?php if ($show_elements && in_array('Title', $show_elements)): ?>
            <div class="column-sub-desc-main-title" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>"
                data-aos-duration="1000">
                <?php $animation_delay += 200; ?>
                <div class="row">
                    <div
                        class="column-main-title <?php echo in_array('Description', $show_elements) ? 'description' : ''; ?>">

                        <h3 class="title"><?php echo esc_html($title); ?></h3>

                        <?php if (in_array('Description', $show_elements)): ?>
                            <div class="desc">
                                <p><?php echo wp_kses_post($description); ?></p>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($video_items)):
				$item_count = count($video_items);
				$grid_column_width = '';

				if ($item_count == 3) {
					$grid_column_width = "col-12 col-sm-6 col-md-6 col-lg-4 ";
				} else {
					$grid_column_width = "col-12 col-sm-6 col-md-6 col-lg-3 ";
				}
            ?>
            <div class="featured-videos">
                <div class="featured-videos-content featured-video-slider row justify-content-center">

                    <?php foreach ($video_items as $video_item):

                        $show_element = $video_item['show_elements'];
                        $sub_title = $video_item['sub_title'];
                        $video_title = $video_item['title'];
                        $video_desc = $video_item['description'];
                        $video_type = $video_item['video_type'];
                        $thumbnail = $video_item['thumbnail'];
                        $video_url = $video_item['video_url'];
                        $video_file = $video_item['video_file'];
                        $button_group = $video_item['button'];

                        // Final video source
                        $feature_video = ($video_type === 'file') ? $video_file : $video_url;
                        $content_class = ($video_title && $video_desc) ? '' : 'no-content';
                        ?>
                        <div class="featured-video <?php echo $grid_column_width; ?>  <?php echo empty($show_element) ? 'only-image' : ''; ?>"
                            data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                            <?php $animation_delay += 200; ?>
                            <div class="content-wrap">
                                <div class="images-contener">
                                    <div class="imgs">
                                        <?php if ($thumbnail): ?>
                                            <img src="<?php echo $thumbnail; ?>" alt="" loading="lazy">
                                        <?php endif; ?>
                                    </div>

                                    <?php if (!empty($feature_video)): ?>
                                        <span class="thumbnails-icon" data-bs-toggle="modal" data-bs-target="#featuredVideoModal"
                                            data-video="<?php echo esc_url($feature_video); ?>">
                                            <span class="play-icon"><i class='bx bx-play'></i></span>
                                        </span>
                                    <?php else: ?>
                                        <span class="thumbnails-icon disabled">
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/play-icon-white.svg"
                                                alt="" loading="lazy">
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($show_element)): ?>
										<div class="content <?php echo esc_attr($content_class); ?> <?php echo (!in_array('Button', $show_element) || empty($button_group)) ? 'no-button' : ''; ?>">
                                        <?php if (in_array('Sub Title', $show_element) && !empty($sub_title)): ?>
                                            <span class="sub_title"><?php echo esc_html($sub_title); ?></span>
                                        <?php endif; ?>
                                        <?php if (in_array('Title', $show_element) && !empty($video_title)): ?>
                                            <h6 class="title"><?php echo esc_html($video_title); ?></h6>
                                        <?php endif; ?>
                                        <?php if (in_array('Description', $show_element) && !empty($video_desc)): ?>
                                            <div class="short-desc"><?php echo wp_kses_post($video_desc); ?></div>
                                        <?php endif; ?>
                                        <?php if (in_array('Button', $show_element) && !empty($button_group)): ?>
                                            <div class="buttons">
                                                <?php if ($button_group): ?>
                                                    <a href="<?php echo esc_url($button_group['link']); ?>" class="btn-readmore">
                                                        <?php echo esc_html($button_group['label']); ?>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- Video Modal -->
<div class="modal fade" id="featuredVideoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <button type="button" class="btnclose" data-bs-dismiss="modal" aria-label="Close">
                <i class='bx bx-x'></i>
            </button>

            <div class="ratio ratio-16x9">
                <iframe id="featured-video-frame" src="" allow="autoplay; encrypted-media" frameborder="0"
                    allowfullscreen></iframe>
            </div>

        </div>
    </div>
</div>

<?php if ($show_slider === true): ?>
    <script>
//         jQuery(document).ready(function ($) {

//             const videoSlider = $('.featured-video-slider');

//             if (videoSlider.length) {
//                 videoSlider.slick({
// 					infinite: false,
//                     slidesToShow: 3,
//                     slidesToScroll: 1,
//                     dots: true,
//                     arrows: true,
//                     autoplay: false,
//                     responsive: [
//                         { breakpoint: 1199, settings: { slidesToShow: 3 } },
//                         { breakpoint: 767, settings: { slidesToShow: 2 } },
//                         { breakpoint: 576, settings: { slidesToShow: 1 } }
//                     ]
//                 });
//             }

//         });
//    
<?php 
	$slides_to_show = ($item_count <= 4) ? $item_count : 3; ?>     
jQuery(document).ready(function ($) {
 	
	 var $section = $('#<?php echo esc_js($section_id); ?>');
    var $slider  = $section.find('.featured-video-slider');
 
    if (!$slider.length) return;
 
    var autoTimer = null;
    var delay     = 2500;
 
    function stopAuto() {
        if (autoTimer) {
            clearInterval(autoTimer);
            autoTimer = null;
        }
    }
 
    function startAuto(slick) {
        stopAuto();
 
        if (!slick || slick.slideCount <= slick.options.slidesToShow) return;
 
        autoTimer = setInterval(function () {
            var lastIndex = slick.slideCount - slick.options.slidesToShow;
 
            if (slick.currentSlide >= lastIndex) {
                $slider.slick('slickGoTo', 0);
            } else {
                $slider.slick('slickNext');
            }
        }, delay);
    }
 
    function toggleDots(slick) {
        if (!slick || !slick.$dots) return;
 
        if (slick.slideCount > slick.options.slidesToShow) {
            slick.$dots.show();
			slick.$dots.removeClass('is-hidden');
        } else {
            slick.$dots.hide();
			slick.$dots.addClass('is-hidden');
        }
    }
 
    /* --------------------------------
     * Slick lifecycle
     * -------------------------------- */
    $slider
        .on('init', function (event, slick) {
            toggleDots(slick);
            startAuto(slick);
        })
        .on('afterChange', function (event, slick) {
            toggleDots(slick);
            startAuto(slick);
        })
        .on('breakpoint', function (event, slick) {
            toggleDots(slick);
        })
        .on('mouseenter', stopAuto)
        .on('mouseleave', function () {
            startAuto($slider.slick('getSlick'));
        });
 
    /* --------------------------------
     * Init Slick
     * -------------------------------- */
    $slider.slick({
        slidesToShow: <?php echo $slides_to_show; ?>,
        slidesToScroll: 1,
        arrows: true,
        dots: true,              // always true, controlled via JS
        infinite: false,
        autoplay: false,
        speed: 500,
        draggable: true,
 
        responsive: [
            { breakpoint: 1199, settings: { slidesToShow: 3 } },
            { breakpoint: 767, settings: { slidesToShow: 2 } },
            { breakpoint: 576, settings: { slidesToShow: 1 } }
        ]
    });
	
	// Equalize visible slide heights
    function equalizeVisibleHeights(slider) {
      const $slides = slider.find('.slick-slide');
      let maxHeight = 0;

      $slides.css('height', 'auto');

      slider.find('.slick-slide.slick-active').each(function () {
        const h = jQuery(this).outerHeight();
        if (h > maxHeight) maxHeight = h;
      });

      slider.find('.slick-slide.slick-active').css('height', maxHeight + 'px');
    }

    // Apply on reposition
    jQuery('.featured-video-slider').on('setPosition', function () {
      equalizeVisibleHeights(jQuery(this));
    });
 
});
    </script>
<?php endif; ?>

<script>
jQuery(document).ready(function ($) {

    const modal  = $('#featuredVideoModal');
    const iframe = $('#featured-video-frame');

    let isModalOpen = false;

    /**
     *  Delegated event (works with Slick clones)
     *  Force-stop previous video before playing new
     */
    $(document).on('click', '.featured_columWrap .thumbnails-icon:not(.disabled)', function (e) {
        e.preventDefault();

        const videoUrl = $(this).data('video');
        if (!videoUrl) return;

        // stop previous video
        iframe.attr('src', '');

        let embedUrl = '';

        // YouTube (watch, short, embed)
        if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {

            let videoId = '';

            if (videoUrl.includes('watch?v=')) {
                videoId = videoUrl.split('watch?v=')[1].split('&')[0];
            } else if (videoUrl.includes('youtu.be/')) {
                videoId = videoUrl.split('youtu.be/')[1].split('?')[0];
            }

            embedUrl = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0';
        }

        // Vimeo
        else if (videoUrl.includes('vimeo.com')) {

            let videoId = videoUrl.split('/').pop().split('?')[0];
            embedUrl = 'https://player.vimeo.com/video/' + videoId + '?autoplay=1';
        }

        // Set iframe
        iframe.attr('src', embedUrl);
    });

    /**
     *  Push history when modal opens
     */
    modal.on('shown.bs.modal', function () {
        if (!isModalOpen) {
            history.pushState({ featuredVideoModal: true }, '');
            isModalOpen = true;
            console.log('PUSH STATE');
        }
    });

    /**
     *  Stop video COMPLETELY on modal close
     */
    modal.on('hidden.bs.modal', function () {
        iframe.attr('src', '');
        isModalOpen = false;
        console.log('MODAL CLOSED');
    });

    /**
     *  Browser back button → close modal
     */
    window.addEventListener('popstate', function (event) {
        console.log('POPSTATE', event.state);

        if (isModalOpen) {
            const modalInstance = bootstrap.Modal.getInstance(
                document.getElementById('featuredVideoModal')
            );

            if (modalInstance) {
                modalInstance.hide();
            }
        }
    });

});
</script>
