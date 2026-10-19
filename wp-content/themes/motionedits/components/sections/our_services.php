<?php
$show_elements = get_sub_field('show_elements');
$title  = get_sub_field('title');
$description  = get_sub_field('description');
$vision_cards = get_sub_field('vision_cards');
$bg_color  = get_sub_field('bg_color');
$custom_class  = get_sub_field('custom_class');
// animation delay counter (ms)
$animation_delay = 0;
?>
<section class="vision_columWrap <?php echo esc_attr($custom_class); ?>" style="background-color: <?php echo $bg_color ?>;">
    <div class="motion-container">
        <div class="vision-inner_wrapper">
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
            <?php if (get_sub_field('columns')): ?>
                <div class="custom-grid service-grid custom-grid-slider">
                    <?php
                    $columns = get_sub_field('columns'); // Get the columns repeater field
                    // Loop through columns
                    foreach ($columns as $column) :
                        $custom_class = $column['custom_class'];
                        $span_class = is_array($column['span_class'])
                            ? implode(' ', $column['span_class'])
                            : $column['span_class'];
                        $items = $column['items'];
                    ?>
                        <?php if ($items): ?>
                            <div class="card <?php echo esc_attr($custom_class); ?> <?php echo esc_attr($span_class); ?>" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                                <?php $animation_delay = 300; ?>
                                <?php foreach ($items as $item) :
                                    $type = $item['type'];
                                    $title = $item['title'];
                                    $text = $item['text'];
                                    $icon = $item['icon'];
                                    $buttons = $item['buttons'];

                                ?>
                                    <?php if ($type === "Title") : ?>
                                        <div class="sub-text">
                                            <?php if ($title) : ?>
                                                <h3><?php echo $title; ?></h3>
                                            <?php endif; ?>
                                        <?php elseif ($type === "Text") : ?>
                                            <?php if ($text) : ?>
                                                <p class="text"><?php echo $text; ?></p>
                                            <?php endif; ?>
                                        </div>
                                    <?php elseif ($type === "Icon") : ?>
                                        <div class="icon">
                                            <?php if ($icon) :
                                                // The image-optimization plugin generates a
                                                // "<file>.webp" sibling next to animated GIFs
                                                // (e.g. foo.gif -> foo.gif.webp) but nothing
                                                // was actually serving it — <img> pointed
                                                // straight at the multi-hundred-KB GIF. Serve
                                                // the WebP sibling when it exists, with the
                                                // original GIF kept as the fallback source.
                                                $icon_webp_path = false;
                                                if (preg_match('/\.gif$/i', $icon)) {
                                                    $upload_dir      = wp_get_upload_dir();
                                                    $icon_fs_path    = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $icon) . '.webp';
                                                    if (file_exists($icon_fs_path)) {
                                                        $icon_webp_path = $icon . '.webp';
                                                    }
                                                }
                                            ?>
                                                <?php if ($icon_webp_path) : ?>
                                                    <picture>
                                                        <source srcset="<?php echo esc_url($icon_webp_path); ?>" type="image/webp">
                                                        <img src="<?php echo esc_url($icon); ?>" alt="" loading="lazy">
                                                    </picture>
                                                <?php else : ?>
                                                    <img src="<?php echo esc_url($icon); ?>" alt="" loading="lazy">
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php elseif ($type === "Buttons") : ?>
                                        <div class="buttons">
                                            <?php
                                            $button = $buttons[0];
                                            $button_url = $button['button_url'];
                                            $button_name = $button['button_name'];
                                            $btn_class = $button['btn_class'];
                                            ?>
                                            <a href="<?php echo $button_url; ?>" class="btn <?php echo $btn_class; ?>">
                                                <?php echo $button_name; ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                    <?php endif;
                    endforeach; ?>
                </div>
            <?php else: ?>
                <?php // No rows found 
                ?>
            <?php endif; ?>
        </div>
    </div>
</section>

