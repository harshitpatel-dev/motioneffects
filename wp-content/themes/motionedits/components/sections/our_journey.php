<?php
$show_elements = get_sub_field('show_elements');
$title = get_sub_field('title');
$description = get_sub_field('description');
$custom_class = get_sub_field('custom_class');
$bg_color = get_sub_field('bg_color');
?>

<section class="our-journey-section timeSlider_wrapper motion-wrap <?php echo esc_attr($custom_class); ?>"
    style="background-color: <?php echo $bg_color ?>">
    <div class="motion-container">
        <div class="">
            <?php if (in_array('Title', $show_elements)): ?>
                <div class="column-sub-desc-main-title pb-0">
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

            <!-- journey slider  -->
            <?php if (get_sub_field('columns')) : ?>
                <div class="section-timeline">
                    <div class="timeline_component">
                        <div class="timeline_progress">
                            <div class="timeline_progress-bar"></div>
                        </div>
                        <?php
                        $columns = get_sub_field('columns'); 
                        foreach ($columns as $column) :
                            $custom_class = $column['custom_class'];
                            $year = $column['year'];
                            $heading = $column['heading'];
                            $image = $column['image'];
                            $description = $column['description'];
                        ?>

                            <div class="timeline_item">
                                <?php if ($year) : ?>
                                    <div class="timeline_left">
                                        <h2 class="timeline_date-text"><?php echo $year; ?></h2>
                                    </div>
                                    <div class="timeline_center">
                                        <div class="timeline_circle"></div>
                                    </div>
                                <?php endif; ?>
                                <div class="timeline_right">
                                    <?php if ($heading) : ?>
                                        <div class="heading-text">
                                            <h3><?php echo $heading; ?></h3>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($image) : ?>
                                        <div class="timeline_image-wrapper">
                                            <img src="<?php echo esc_url($image); ?>" alt="" loading="lazy">
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($description) : ?>
                                        <div class="margin-bottom-xlarge">
                                            <div class="desc">
                                                <?php echo $description; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else : ?>
                <?php // No rows found 
                ?>
            <?php endif; ?>
        </div>

    </div>
</section>