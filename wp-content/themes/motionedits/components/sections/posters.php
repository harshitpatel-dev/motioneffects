<?php
$show_elements = get_sub_field('show_elements');
$title  = get_sub_field('title');
$description  = get_sub_field('description');
$poster_items = get_sub_field('poster_items');
$bg_color  = get_sub_field('bg_color');
$custom_class  = get_sub_field('custom_class');
// animation delay counter (ms)
$animation_delay = 0;
?>
<section class="our_poster_columWrap <?php echo esc_attr($custom_class); ?>" style="background-color: <?php echo $bg_color ?>;">
    <div class="motion-container">
        <?php if (in_array('Title', $show_elements)) : ?>
            <div class="column-sub-desc-main-title pb-0" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                <?php $animation_delay += 200; ?>
                <div class="row">
                    <div class="column-main-title <?php if (in_array('Description', $show_elements)): ?>description<?php endif; ?>">
                        <?php if (in_array('Title', $show_elements)) : ?>
                            <h3 class="title"><?php echo $title; ?></h3>
                        <?php endif; ?>

                        <?php if (in_array('Description', $show_elements)) : ?>
                            <div class="desc">
                                <p><?php echo $description; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($poster_items)): ?>
            <div class="posters-container" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                <?php $animation_delay += 200; ?>
                <div class="posters-content poster-slider row justify-content-center">
                    <?php foreach ($poster_items as $poster_index => $poster_item):
                        $image_url = $poster_item['poster']['url'];
                        $alt_title = $poster_item['poster']['title'];
                        $image_width = $poster_item['poster']['width'];
                        $image_height = $poster_item['poster']['height'];
                        $is_first = $poster_index === 0;
                    ?>
                        <div class="poster-card col-md-4 col-lg-4">
                            <?php if (!empty($image_url)): ?>
                                <div class="image-wrapper">
                                    <img src="<?php echo $image_url; ?>" alt="<?php echo $alt_title; ?>" width="<?php echo esc_attr($image_width); ?>" height="<?php echo esc_attr($image_height); ?>" <?php echo $is_first ? 'fetchpriority="high" loading="eager"' : 'loading="lazy"'; ?> />
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        <?php endif; ?>

    </div>
</section>


