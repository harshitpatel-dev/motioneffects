<?php
$show_elements = get_sub_field('show_elements');
$title = get_sub_field('title');
$description  = get_sub_field('description');
$button  = get_sub_field('button');
$show_options = get_sub_field('show_options');
$custom_class  = get_sub_field('custom_class');
$background_style  = get_sub_field('bg_color');

// Simple animation delay counter (ms)
$animation_delay = 0;
?>

<section class="accordian_columWrap <?php echo esc_attr($custom_class); ?>"
    style="background-color: <?php echo esc_attr($background_style); ?>">
    <div class="motion-container">
        <div class="faq-accordion">
            <div class="row">
                
                <!-- LEFT TITLE / DESCRIPTION -->
                <div class="col-xl-3 col-lg-4">
                    <?php if (in_array('Title', $show_elements)) : ?>
                        <div class="column-sub-desc-main-title">
                            <div class="row">
                                <div class="col-12">
                                    <div class="column-main-title <?php if (in_array('Description', $show_elements)): ?>description<?php endif; ?>">
                                        
                                        <!-- Title -->
                                        <?php if (in_array('Title', $show_elements)) : ?>
                                            <h3 class="title" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000"><?php echo esc_html($title); ?></h3>
										<?php $animation_delay = 100; ?>
                                        <?php endif; ?>

                                        <!-- Description -->
                                        <?php if (in_array('Description', $show_elements)) : ?>
                                            <div class="desc" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000"><?php echo wp_kses_post($description); ?></div>
										<?php $animation_delay = 100; ?>
                                        <?php endif; ?>

                                        <!-- Button -->
                                        <?php if (in_array('Button', $show_elements)) : ?>
                                            <div class="buttons desktop-btn" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
										<?php $animation_delay = 100; ?>
                                                <?php ob_start(); ?>
                                                    <?php if(!empty($button)): 
                                                        $button_link = $button['link'];
                                                        $button_name = $button['label'];
                                                        $btn_class = $button['btn_class'];
                                                    ?>
                                                        <?php if($button_name):?>
                                                            <a href="<?php echo $button_link; ?>" class="btn <?php echo $btn_class; ?>"><?php echo $button_name; ?></a>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php echo $button_html = ob_get_clean(); ?>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- RIGHT FAQ SECTION -->
                <div class="col-xl-9 col-lg-8 question-right">

                    <?php if($show_options === "With Category"): ?> 

                        <?php if (have_rows('accordian_list')) : ?>
                            <?php while (have_rows('accordian_list')) : the_row(); ?>

                                <?php
                                $category_terms = get_sub_field('category_name');
                                $faq_category = '';

                                if ($category_terms instanceof WP_Term) {
                                    $faq_category = $category_terms->slug;
                                } elseif (is_array($category_terms) && !empty($category_terms)) {
                                    $faq_category = $category_terms[0]->slug;
                                }
                                ?>

                                <!-- SINGLE CATEGORY BLOCK -->
                                <div class="accordionfaq-content faq-block faq-<?php echo esc_attr($faq_category); ?>" style="display:none;">

                                    <?php if (have_rows('accordian_items')) : ?>
                                        <div class="accordion" id="accordion-<?php echo esc_attr($faq_category); ?>">

                                            <?php
                                            $itemCount = 0;
                                            while (have_rows('accordian_items')) : the_row();
                                                $item_title = get_sub_field('title');
                                                $item_desc = get_sub_field('description');

                                                $open = $itemCount === 0 ? 'show' : '';
                                                $expanded = $itemCount === 0 ? 'true' : 'false';
                                                $collapsed = $itemCount === 0 ? '' : 'collapsed';

                                                $itemID = $faq_category . '-' . $itemCount;
                                            ?>

                                                <div class="accordion-item" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
											      <?php $animation_delay += 100; ?>
                                                    <h6 class="accordion-header" id="heading-<?php echo $itemID; ?>">
                                                        <button class="accordion-button <?php echo $collapsed; ?>"
                                                                type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapse-<?php echo $itemID; ?>"
                                                                aria-expanded="<?php echo $expanded; ?>"
                                                                aria-controls="collapse-<?php echo $itemID; ?>">
                                                            <span><?php echo esc_html($item_title); ?></span>
                                                        </button>
                                                    </h6>

                                                    <div id="collapse-<?php echo $itemID; ?>"
                                                        class="accordion-collapse collapse <?php echo $open; ?>"
                                                        aria-labelledby="heading-<?php echo $itemID; ?>"
                                                        data-bs-parent="#accordion-<?php echo esc_attr($faq_category); ?>">

                                                        <div class="accordion-body">
                                                            <?php echo wp_kses_post($item_desc); ?>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php
                                                $itemCount++;
                                            endwhile;
                                            ?>

                                        </div>
                                    <?php endif; ?>

                                </div>

                            <?php endwhile; ?>
                        <?php endif; ?>
                    <?php elseif($show_options === "WithOut Category"): ?>
                        <?php if (have_rows('accordian_items')) : ?>
                            <div class="accordionfaq-content">
                                <div class="accordion" id="accordionFaq">
                                    <?php
                                    $itemCount = 0;
                                    while (have_rows('accordian_items')) : the_row();
                                        $item_title = get_sub_field('title');
                                        $item_desc = get_sub_field('description');
                                        $isActive = $itemCount === 0 ? 'show' : '';
                                        $ariaExpanded = $itemCount === 0 ? 'true' : 'false';
                                        $collapsedClass = $itemCount === 0 ? '' : 'collapsed'; // <-- fix
                                    ?>
                                        <div class="accordion-item" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
										  <?php $animation_delay += 100; ?>
                                            <h6 class="accordion-header" id="heading-<?php echo $itemCount; ?>">
                                                <button class="accordion-button <?php echo $collapsedClass; ?>"
                                                    type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-<?php echo $itemCount; ?>"
                                                    aria-expanded="<?php echo $ariaExpanded; ?>"
                                                    aria-controls="collapse-<?php echo $itemCount; ?>">
                                                    <span><?php echo esc_html($item_title); ?></span>
                                                </button>
                                            </h6>
                                            <div id="collapse-<?php echo $itemCount; ?>"
                                                class="accordion-collapse collapse <?php echo $isActive; ?>"
                                                aria-labelledby="heading-<?php echo $itemCount; ?>"
                                                data-bs-parent="#accordionFaq">
                                                <div class="accordion-body">
                                                    <?php echo wp_kses_post($item_desc); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                        $itemCount++;
                                    endwhile;
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    <?php endif; ?>
                </div>

                <div class="buttons mobile-btn d-none"><?php echo $button_html; ?></div>

            </div>
        </div>
    </div>
</section>


<!-- FILTER SCRIPT -->
