<?php
	$show_elements = get_sub_field( 'show_elements' );
    $title  = get_sub_field( 'title' );
    $description  = get_sub_field( 'description' );
    $package_details = get_sub_field("package_details");
    $bg_color  = get_sub_field( 'bg_color' );
    $custom_class  = get_sub_field( 'custom_class' );
    // animation delay counter (ms)
    $animation_delay = 0;
?>
<section class="packagesWrap <?php echo esc_attr($custom_class); ?>" id="packages" style="background-color: <?php echo $bg_color ?>;">
	<div class="motion-container">
		<div class="packages-inner-wrapper">
            <?php if( in_array('Title',$show_elements)) : ?>
                <div class="column-sub-desc-main-title" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
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

            <?php if(!empty($package_details)): ?>
                <div class="packages_plans">
                    <div class="row packages-plans-inner packages-slider">
                        <?php 
                            foreach ($package_details as $package_detail):
                            $package_title = $package_detail['package_title'];
                            $price_range = $package_detail['price_range'];
                            $price_sub_title = $package_detail['price_sub_title'];
                            $package_features = $package_detail['package_features'];
                            $buttons = $package_detail['buttons'];
						
							if(!empty($buttons)){
								$label = $buttons['label'];
								$link = $buttons['link'];
							}
                        ?>

                        <div class="col-sm-12 col-lg-4 col-xl-4 pricing-column" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                            <?php $animation_delay += 100; ?>
                            <div class="packages-card">
                                <div class="item-wrapper">
                                    <div class="package-title">
                                        <?php echo $package_title;?>
                                    </div>
                                    
                                    <div class="price-range">
                                        <?php echo $price_range ;?>
                                        <span><?php echo $price_sub_title ;?></span>
                                    </div>

                                    <ul class="plan-list">
                                        <?php foreach ($package_features as $package_feature):?>
                                            <li> <?php echo $package_feature['feature']; ?></li>
                                        <?php endforeach;?>
                                    </ul>

                                    <?php if(!empty($label) && !empty($link)):?>
									<div class="buttons">
                                        <a href="<?php echo $link;?>" role="button" class="btn btn-green select-plan"><?php echo $label;?></a>
                                    </div>
									<?php endif;?>
                                </div>
                            </div>
                        </div>

                        <?php endforeach ;?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
	</div>
</section>