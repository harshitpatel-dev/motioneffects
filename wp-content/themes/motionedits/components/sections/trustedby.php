<?php
$show_elements = get_sub_field('show_elements');
$title = get_sub_field('title');
$description = get_sub_field('description');
$team_members = get_sub_field('team_members');
$custom_class = get_sub_field('custom_class');
$bg_color = get_sub_field('bg_color');
// animation delay counter (ms)
$animation_delay = 0;
?>

<section class="trustedby_wrapper motion-wrap <?php echo esc_attr($custom_class); ?>">
    <div class="motion-container">
        <div class="trustedby_wrapper-containers" style="background-color: <?php echo $bg_color ?>">
            <?php if (in_array('Title', $show_elements)): ?>
                <div class="column-sub-desc-main-title pb-0" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                    <?php $animation_delay += 200; ?>
                    <div class="row">
                        <div
                            class="column-main-title <?php if (in_array('Description', $show_elements)): ?>description<?php endif; ?>">
                            <?php if (in_array('Title', $show_elements)): ?>
                                <h3 class="title"><?php echo $title; ?></h3>
                            <?php endif; ?>

                            <?php if (in_array('Description', $show_elements)): ?>
                                <div class="desc">
                                    <p><?php echo $description; ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Trusted by Creators Worldwide  -->
            <?php if (get_sub_field('columns')) : ?>
                <div class="main-column">
                    <div class="main-row">
                        <?php
                        $columns = get_sub_field('columns');
                        foreach ($columns as $column) :
                            $column_class = is_array($column['column_class'])
                                ? implode(' ', $column['column_class'])
                                : $column['column_class'];
                            $items = $column['items'];
                            $custom_class = $column['custom_class'];
                        ?>
                            <?php if ($items): ?>
                                <div class="column-items <?php echo esc_attr($custom_class); ?>" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                                    <?php $animation_delay += 100; ?>
                                    <div class="column-items-wrapper">
                                        <?php
                                        $columns = get_sub_field('columns');
                                        foreach ($items as $item) :
                                            $column_class = is_array($column['column_class'])
                                                ? implode(' ', $column['column_class'])
                                                : $item['column_class'];

                                            $custom_class = $item['custom_class'];
                                            $text_title = $item['text_title'];
                                            $title = $item['title'];
                                            $description = $item['description'];
                                            $custom_class = $item['custom_class'];
                                        ?>
                                            <div class="<?php echo esc_attr($custom_class); ?> main-texts" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                                                <?php $animation_delay = 300; ?>
                                                <div class="content-titles">
                                                    <?php if(!empty($text_title)):?>
                                                        <h3 class="text_title"><?php echo $text_title; ?></h3>
                                                    <?php endif;?>
                                                    <?php if(!empty($title)):?>
                                                        <h6 class="title"><?php echo $title; ?></h6>
                                                    <?php endif;?>
                                                </div>
                                                <?php if(!empty($description)):?>
                                                    <div class="description">
                                                        <p><?php echo $description; ?></p>
                                                    </div>
                                                <?php endif;?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                        <?php endif;
                        endforeach; ?>
                    </div>
                </div>
            <?php else : ?>
                <?php // No rows found 
                ?>
            <?php endif; ?>
        </div>

    </div>
</section>