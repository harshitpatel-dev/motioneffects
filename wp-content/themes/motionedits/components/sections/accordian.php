<?php
$show_elements = get_sub_field('show_elements');
$title = get_sub_field('title');
$description  = get_sub_field('description');
$button  = get_sub_field('button');
$custom_class  = get_sub_field('custom_class');
$background_style  = get_sub_field('bg_color');
?>

<section class="accordian_columWrap <?php echo esc_attr($custom_class); ?>"
    style="background-color: <?php echo esc_attr($background_style); ?>">
    <div class="motion-container">
        <div class="faq-accordion">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <?php if (in_array('Title', $show_elements)) : ?>
                        <div class="column-sub-desc-main-title">
                            <div class="row">
                                <div class="col-12">
                                    <div class="column-main-title <?php if (in_array('Description', $show_elements)): ?>description<?php endif; ?>">
                                        
                                        <?php if (in_array('Title', $show_elements)) : ?>
                                            <h3 class="title"><?php echo esc_html($title); ?></h3>
                                        <?php endif; ?>

                                        <?php if (in_array('Description', $show_elements)) : ?>
                                            <div class="desc"><?php echo wp_kses_post($description); ?></div>
                                        <?php endif; ?>

                                        <?php if (in_array('Button', $show_elements)) : ?>
                                            <div class="buttons desktop-btn">
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

                <div class="col-xl-9 col-lg-8 question-right">
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
                                    <div class="accordion-item">
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
                </div>

                <div class="buttons mobile-btn d-none"><?php echo $button_html; ?></div>

            </div>
        </div>
    </div>
</section>
