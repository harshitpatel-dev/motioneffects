<?php
$show_elements = get_sub_field( 'show_elements' );
$title  = get_sub_field( 'title' );
$description  = get_sub_field( 'description' );
$bg_color  = get_sub_field( 'bg_color' );
$custom_class  = get_sub_field( 'custom_class' );
// animation delay counter (ms)
$animation_delay = 0;
?>

<section class="culture-slider motion-wrap <?php echo esc_attr($custom_class); ?>" style="background-color: <?php echo $bg_color ?>;">
    <div class="motion-container">
        <div class="culture-inner_wrapper">
            <?php if( in_array('Title',$show_elements)) : ?>
                <div class="column-sub-desc-main-title pb-0" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                    <?php $animation_delay += 100; ?>
                    <div class="row">
                        <div class="column-main-title <?php if(in_array('Description',$show_elements)): ?>description<?php endif; ?>">
                            <?php  if( in_array('Title',$show_elements)) : ?>
                                <h3 class="title"><?php echo $title; ?></h3>
                            <?php endif; ?>

                            <?php  if( in_array('Description',$show_elements)) : ?>
                                <div class="desc">
                                    <p><?php echo $description;?></p>
                                </div>
                            <?php endif; ?>
                        </div>	
                    </div>
                </div>
            <?php endif; ?>

            <?php $items = get_sub_field('items'); ?>
            <?php if ($items) : ?>
                <div class="slider-item-container" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                    <?php $animation_delay += 100; ?>
                    <?php foreach ($items as $index => $item) :
                        $direction = $item['direction'] ?? 'left';
                        $speed = $item['speed'] ?? 'fast';
                        $images = $item['images'] ?? []; ?>
                        <?php if (!empty($images)) : ?>
                            <div class="slider-items">
                                <div class="items-wrap h-100">
                                    <div class="smooth-slider-container scroller" data-direction="<?php echo esc_attr($direction); ?>" data-speed="<?php echo $speed;?>">
                                        <div class="scroll-list scroller__inner">
                                            <?php foreach ($images as $image) : ?>
                                                <div class="scroll-item">
                                                    <div class="image-wrapper">
                                                        <div class="image-item skeleton-wrapper">
                                                            <div class="skeleton"></div>
                                                            <img src="<?php echo esc_url($image['image']); ?>" alt="Gallery Image" fetchpriority="high" loading="lazy"  class="lazy-img">
                                                            <!-- <img src="<?php //echo get_template_directory_uri(); ?>/imgs/default-image.png" data-src="<?php echo esc_url($image['image']); ?>" alt="Gallery Image" loading="lazy"  class="lazy-img"> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
    const scrollers = document.querySelectorAll(".scroller");

    // If a user hasn't opted in for recuded motion, then we add the animation
    if (!window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    addAnimation();
    }

    function addAnimation() {
        scrollers.forEach((scroller) => {
            // add data-animated="true" to every `.scroller` on the page
            scroller.setAttribute("data-animated", true);

            const scrollerInner = scroller.querySelector(".scroller__inner");
            const scrollerContent = Array.from(scrollerInner.children);

            scrollerContent.forEach((item) => {
            const duplicatedItem = item.cloneNode(true);
            duplicatedItem.setAttribute("aria-hidden", true);
            scrollerInner.appendChild(duplicatedItem);
            });
        });
    }


    document.addEventListener("DOMContentLoaded", function () {
        const lazyImages = document.querySelectorAll("img.lazy-img");

        lazyImages.forEach(img => {
            if (img.complete) {
            handleImageLoad(img);
            } else {
            img.addEventListener("load", function () {
                handleImageLoad(img);
            });
            }

        });

        function handleImageLoad(img) {
            img.classList.add("loaded");
            const skeleton = img.parentElement.querySelector(".skeleton");
            if (skeleton) {
            skeleton.remove();
            }
        }
    });

</script>