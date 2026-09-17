<?php 
$section_id = 'grid-section-' . get_row_index();
$show_elements      = get_sub_field('show_elements');
$main_title         = get_sub_field('columns_title'); 
$description        = get_sub_field('description');
$show_options       = get_sub_field('show_grid');
$bg_color           = get_sub_field('bg_color');
$mobile_slider      = get_sub_field('mobile_slider');
$custom_class       = get_sub_field('custom_class');
$grid_column_count  = get_sub_field('grid_column'); // ONLY for Services (3 or 4)
$grids              = [];
$mobile_slider_class= '';
// Simple animation delay counter (ms)
$animation_delay = 0;

// Fetch grids
if (have_rows('grid_columns')) {
    while (have_rows('grid_columns')) { the_row();
        $grids[] = [
            'icon'        => get_sub_field('icon'),
            'title'       => get_sub_field('title'),
            'description' => get_sub_field('description'),
            'buttons'     => get_sub_field('buttons'),
        ];
    }
}
$total_grids = count($grids);
$grid_odd_class = ($total_grids % 2 !== 0) ? ' odd-grid' : '';

if($mobile_slider){
    $mobile_slider_class= 'mobile-grid-slider mobile-slider-enabled';
}
?>
<section class="grid_columnWrap motion-wrap <?php echo $custom_class; ?>" style="background-color: <?php echo $bg_color; ?>;" id="<?php echo esc_attr($section_id); ?>">
    <div class="motion-container">
        <div class="grid_column">
            <!-- TITLE + DESCRIPTION -->
            <?php if(in_array('Title', $show_elements)) : ?>
                <div class="column-sub-desc-main-title" <?php if (!empty($main_title) || !empty($description)) { ?>data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000"<?php $animation_delay += 200; } ?> >
                    <div class="row">
                        <div class="col-12">
                            <div class="column-main-title <?php echo in_array('Description',$show_elements) ? 'description' : ''; ?>">
                                <h3 class="title"><?php echo $main_title; ?></h3>
                                <?php if(in_array('Description', $show_elements)): ?>
                                    <div class="desc"><?php echo $description; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- SERVICES -->
            <?php if($show_options === "Services" && $total_grids > 0): 
                
                // Determine Services column class
                $col_class = ($grid_column_count == 4) 
                    ? 'col-md-3 col-lg-3'
                    : 'col-md-4 col-lg-4'; // default for 3-columns
                ?>
                <div class="grid_column_columns Services">
                    <div class="grid-services-slider row justify-content-center <?php echo $grid_odd_class;?>">

                        <?php foreach($grids as $grid): ?>
                            <div class="grid <?php echo $col_class; ?>" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                                <?php $animation_delay += 100; ?>
								<?php
                                    if(empty($grid['buttons']['button_url'])): $anchor_class = "remove-bottom-space";
                                    else: $anchor_class = "";
                                    endif;
								
								$icon = $grid['icon'];
						$is_svg = pathinfo($icon['url'], PATHINFO_EXTENSION) === 'svg';
						if ($is_svg && (empty($icon['width']) || empty($icon['height']))) {
							list($icon['width'], $icon['height']) = motionedits_get_svg_dimensions($icon['url']);
						}
								$is_gif = str_ends_with(strtolower($icon['url']), '.gif');

								// The image-optimization plugin generates a "<file>.webp"
								// sibling next to animated GIFs (foo.gif -> foo.gif.webp)
								// but nothing served it - <img> loaded the raw multi-hundred-KB
								// GIF directly. Serve the WebP sibling when it exists.
								$icon_webp_url = false;
								if ($is_gif) {
									$upload_dir   = wp_get_upload_dir();
									$icon_fs_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $icon['url']) . '.webp';
									if (file_exists($icon_fs_path)) {
										$icon_webp_url = $icon['url'] . '.webp';
									}
								}
                                ?>
                                <div class="grid_column_columns-inner content-wrap <?php echo $anchor_class;?>">

                                    <div class="icon-title">
                                        <?php if($grid['icon']): ?>
                                            <div class="iconWrap">
                                                <?php if(is_array($grid['icon'])): ?>
                                                <?php if ($icon_webp_url): ?><picture><source srcset="<?php echo esc_url($icon_webp_url); ?>" type="image/webp"><?php endif; ?>
												<img
            src="<?php echo esc_url($icon['url']); ?>"
            alt="<?php echo esc_attr($icon['alt'] ?: $grid['title']); ?>"
            loading="<?php echo $is_gif ? 'lazy' : 'eager'; ?>"
            fetchpriority="<?php echo $is_gif ? 'low' : ''; ?>"
            <?php if (!empty($icon['width']) && !empty($icon['height'])): ?>
                width="<?php echo esc_attr($icon['width']); ?>"
                height="<?php echo esc_attr($icon['height']); ?>"
            <?php endif; ?>
        >
                                                <?php if ($icon_webp_url): ?></picture><?php endif; ?>
                                                <?php else: ?>
                                                    <img src="<?php echo esc_url($grid['icon']); ?>" alt="" fetchpriority="<?php echo $is_gif ? 'low' : ''; ?>" loading="lazy">
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if($grid['title']): ?>
                                            <h6 class="title"><?php echo esc_html($grid['title']); ?></h6>
                                        <?php endif; ?>
                                    </div>

                                    <?php if($grid['description']): ?>
                                        <div class="content-description">
                                            <p><?php echo esc_html($grid['description']); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if(!empty($grid['buttons']['button_name'])): ?>
                                        <div class="button-wrapper">
                                            <div class="buttons">
                                                <a href="<?php echo esc_url($grid['buttons']['button_url']); ?>" class="btn-viewmore">
                                                    <?php echo esc_html($grid['buttons']['button_name']); ?>
                                                    <!-- <span><img src="<?php echo get_template_directory_uri(); ?>/images/right-arrow.svg"></span> -->
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            <?php endif; ?>


            <!-- TOOLS -->
            <?php if($show_options === "Tools" && $total_grids > 0): ?>

                <?php
                // Build row structure: best-case single row if fits
                if($total_grids <= 4){
                    // Single row only
                    $row_structure = [$total_grids];
                } else {
                    // Your original logic (3/2 grouping)
                    $row_structure = [];
                    $remaining = $total_grids;

                    while ($remaining > 0) {
                        if ($remaining >= 3) { 
                            $row_structure[] = 3; 
                            $remaining -= 3;
                        } else {
                            $row_structure[] = $remaining;
                            $remaining = 0;
                        }
                    }
                }
                ?>

                <div class="grid_column_columns Tools">
                    <div class="<?php echo $mobile_slider_class;?> <?php echo $grid_odd_class;?> row justify-content-center">

                        <?php 
                        $grid_index = 0;
                        foreach($row_structure as $row_count):
                            for($i = 0; $i < $row_count; $i++):
                                if(!isset($grids[$grid_index])) break;

                                $grid = $grids[$grid_index];

                                // Column class for Tools
                                if ($row_count == 3) $col = 'col-sm-6 col-lg-4';
                                elseif ($row_count == 2) $col = 'col-sm-6';
						        elseif ($row_count == 4) $col = 'col-sm-6';
                                else $col = 'col-md-12';
						$icon = $grid['icon'];
						$is_svg = pathinfo($icon['url'], PATHINFO_EXTENSION) === 'svg';
						if ($is_svg && (empty($icon['width']) || empty($icon['height']))) {
							list($icon['width'], $icon['height']) = motionedits_get_svg_dimensions($icon['url']);
						}
						$is_gif = str_ends_with(strtolower($icon['url']), '.gif');

						// See the "Services" branch above for why: serve the
						// already-generated WebP sibling of animated GIFs instead
						// of the raw GIF when one exists on disk.
						$icon_webp_url = false;
						if ($is_gif) {
							$upload_dir   = wp_get_upload_dir();
							$icon_fs_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $icon['url']) . '.webp';
							if (file_exists($icon_fs_path)) {
								$icon_webp_url = $icon['url'] . '.webp';
							}
						}
                        ?>
                            <div class="grid <?php echo $col; ?>" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                                <?php $animation_delay += 100; ?>
                                <div class="grid_column_columns-inner content-wrap">

                                    <div class="icon-title">
                                        <?php if($grid['icon']): ?>
                                            <div class="iconWrap">
                                                <?php if(is_array($grid['icon'])): ?>
                                                <?php if ($icon_webp_url): ?><picture><source srcset="<?php echo esc_url($icon_webp_url); ?>" type="image/webp"><?php endif; ?>
												 <img
            src="<?php echo esc_url($icon['url']); ?>"
            alt="<?php echo esc_attr($icon['alt'] ?: $grid['title']); ?>"
            loading="<?php echo $is_gif ? 'lazy' : 'eager'; ?>"
            fetchpriority="<?php echo $is_gif ? 'low' : ''; ?>"
            <?php if (!empty($icon['width']) && !empty($icon['height'])): ?>
                width="<?php echo esc_attr($icon['width']); ?>"
                height="<?php echo esc_attr($icon['height']); ?>"
            <?php endif; ?>
        >
                                                <?php if ($icon_webp_url): ?></picture><?php endif; ?>
                                                <?php else: ?>
                                                    <img src="<?php echo esc_url($grid['icon']); ?>" fetchpriority="<?php echo $is_gif ? 'low' : ''; ?>" loading="lazy">
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if($grid['title']): ?>
                                            <h6 class="title"><?php echo esc_html($grid['title']); ?></h6>
                                        <?php endif; ?>
                                    </div>

                                    <?php if($grid['description']): ?>
                                        <div class="content-description">
                                            <p><?php echo esc_html($grid['description']); ?></p>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>

                        <?php 
                            $grid_index++;
                            endfor;
                        endforeach; 
                        ?>

                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<!-- JS FOR SERVICES SLIDER -->
<?php if($show_options === "Services"): ?>
<script>
jQuery(document).ready(function ($) {

    var $section = $('#<?php echo esc_js($section_id); ?>');
    var $slider  = $section.find('.grid-services-slider');

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
        slidesToShow: <?php echo (int) $grid_column_count; ?>,
        slidesToScroll: 1,
        arrows: true,
        dots: true,              // always true, controlled via JS
        infinite: false,
        autoplay: false,
        speed: 500,
        draggable: true,
/* 🔥 Drag & swipe tuning */
    swipe: true,
    touchMove: true,
    swipeToSlide: false,
					
					touchThreshold: 4,   // LOWER = faster swipe
    speed: 250,          // FAST animation
    cssEase: 'cubic-bezier(0.4, 0, 0.2, 1)', // Google Material easing

    /* Prevent sluggish feel */
    waitForAnimate: false,
    edgeFriction: 0.15,

    /* Stability */
    accessibility: false,
		adaptiveHeight: false,
        responsive: [
            { breakpoint: 1360, settings: { slidesToShow: 3 } },
            { breakpoint: 1199, settings: { slidesToShow: 3 } },
            { breakpoint: 991,  settings: { slidesToShow: 2 } },
            { breakpoint: 576,  settings: { slidesToShow: 1 } }
        ]
    });

});

</script>

<?php endif; ?>

<!-- JS FOR TOOLS MOBILE SLIDER -->
<?php if($show_options === "Tools" && $mobile_slider): ?>
<script>
jQuery(document).ready(function($){

    var $section = $('#<?php echo esc_js($section_id); ?>');
    var slider   = $section.find('.mobile-grid-slider');

    function initToolsMobileSlider(){

        if(window.innerWidth <= 767){
            if(!slider.hasClass('slick-initialized')){
                slider.slick({
					infinite: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    arrows: true,
                    autoplay: false,
					
					 /* 🔥 Drag & swipe tuning */
    swipe: true,
    draggable: true,
    touchMove: true,
    swipeToSlide: false,
					
					touchThreshold: 4,   // LOWER = faster swipe
    speed: 250,          // FAST animation
    cssEase: 'cubic-bezier(0.4, 0, 0.2, 1)', // Google Material easing

    /* Prevent sluggish feel */
    waitForAnimate: false,
    edgeFriction: 0.15,

    /* Stability */
    accessibility: false,
					adaptiveHeight: false,
                });
            }
        } else {
            if(slider.hasClass('slick-initialized')){
                slider.slick('unslick');
            }
        }
    }

    initToolsMobileSlider();
    $(window).on('resize', initToolsMobileSlider);

});
</script>
<?php endif; ?>