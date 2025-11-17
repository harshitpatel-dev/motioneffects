<?php 
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

if($mobile_slider){
    $mobile_slider_class= 'mobile-grid-slider mobile-slider-enabled';
}
?>
<section class="grid_columnWrap motion-wrap <?php echo $custom_class; ?>" style="background-color: <?php echo $bg_color; ?>;">
    <div class="motion-container">
        <div class="grid_column">

            <!-- TITLE + DESCRIPTION -->
            <?php if(in_array('Title', $show_elements)) : ?>
                <div class="column-sub-desc-main-title">
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
                    <div class="grid-services-slider row justify-content-center">

                        <?php foreach($grids as $grid): ?>
                            <div class="grid <?php echo $col_class; ?>">
                                <div class="grid_column_columns-inner content-wrap">

                                    <div class="icon-title">
                                        <?php if($grid['icon']): ?>
                                            <div class="iconWrap">
                                                <?php if(is_array($grid['icon'])): ?>
                                                    <img src="<?php echo esc_url($grid['icon']['url']); ?>" alt="<?php echo esc_attr($grid['icon']['alt']); ?>">
                                                <?php else: ?>
                                                    <img src="<?php echo esc_url($grid['icon']); ?>" alt="">
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
                                                    <span><img src="<?php echo get_template_directory_uri(); ?>/images/right-arrow.svg"></span>
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
                    <div class="<?php echo $mobile_slider_class;?> row justify-content-center">

                        <?php 
                        $grid_index = 0;
                        foreach($row_structure as $row_count):
                            for($i = 0; $i < $row_count; $i++):
                                if(!isset($grids[$grid_index])) break;

                                $grid = $grids[$grid_index];

                                // Column class for Tools
                                if ($row_count == 3) $col = 'col-sm-6 col-lg-4';
                                elseif ($row_count == 2) $col = 'col-md-6';
                                else $col = 'col-md-12';
                        ?>
                            <div class="grid <?php echo $col; ?>">
                                <div class="grid_column_columns-inner content-wrap">

                                    <div class="icon-title">
                                        <?php if($grid['icon']): ?>
                                            <div class="iconWrap">
                                                <?php if(is_array($grid['icon'])): ?>
                                                    <img src="<?php echo esc_url($grid['icon']['url']); ?>">
                                                <?php else: ?>
                                                    <img src="<?php echo esc_url($grid['icon']); ?>">
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
jQuery(document).ready(function($){

    $('.grid-services-slider').slick({
        slidesToShow: <?php echo (int) $grid_column_count; ?>,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        autoplay: true,
        responsive: [
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });
});
</script>
<?php endif; ?>

<!-- JS FOR TOOLS MOBILE SLIDER -->
<?php if($show_options === "Tools" && $mobile_slider): ?>
<script>
jQuery(document).ready(function($){

    function initToolsMobileSlider(){
        var slider = $('.mobile-grid-slider');

        if(window.innerWidth <= 576){
            if(!slider.hasClass('slick-initialized')){
                slider.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    arrows: false,
                    autoplay: true
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
