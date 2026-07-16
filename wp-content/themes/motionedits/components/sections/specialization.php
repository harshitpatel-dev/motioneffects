<?php
	$show_elements = get_sub_field( 'show_elements' );
    $title  = get_sub_field( 'title' );
    $description  = get_sub_field( 'description' );
    $specialization_cards = get_sub_field( 'specialization_cards' );
    $bg_color  = get_sub_field( 'bg_color' );
    $custom_class  = get_sub_field( 'custom_class' );
    // animation delay counter (ms)
    $animation_delay = 0;
?>
<section class="specialize_columWrap <?php echo esc_attr($custom_class); ?>" style="background-color: <?php echo $bg_color ?>;">
	<div class="motion-container">
		<div class="specialize-inner_wrapper">
            <?php if( in_array('Title',$show_elements)) : ?>
                <div class="column-sub-desc-main-title pb-0" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                    <?php $animation_delay += 200; ?>
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

            <?php if(!empty($specialization_cards)):?>
                <div class="specialize-container">
                    <div class="specialize-content row justify-content-center">
                        <?php foreach ( $specialization_cards as $specialization_card ): 
                            $icon = $specialization_card['icon'];
                            $title = $specialization_card['title'];
                        ?>
                            <div class="specialize-card col-6 col-sm-4 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                                <?php $animation_delay = 200; ?>
                                <div class="content-wrapper">
                                    <?php if(!empty($icon) && !empty($title)): ?>
                                        <div class="image-wrapper">
                                            <img src="<?php echo $icon;?>" alt="<?php echo $title;?>" fetchpriority="high" loading="lazy" />
                                        </div>
                                    <?php endif; ?>
                                    <?php if(!empty($title)): ?>
                                        <div class="title pb-0">
                                            <h5> <?php echo $title; ?> </h5>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
	</div>
</section>