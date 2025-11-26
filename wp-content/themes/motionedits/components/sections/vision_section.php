<?php
	$show_elements = get_sub_field( 'show_elements' );
    $title  = get_sub_field( 'title' );
    $description  = get_sub_field( 'description' );
    $vision_cards = get_sub_field( 'vision_cards' );
    $bg_color  = get_sub_field( 'bg_color' );
    $custom_class  = get_sub_field( 'custom_class' );
?>
<section class="vision_columWrap <?php echo esc_attr($custom_class); ?>" style="background-color: <?php echo $bg_color ?>;">
	<div class="motion-container">
		<div class="vision-inner_wrapper">
            <?php if( in_array('Title',$show_elements)) : ?>
                <div class="column-sub-desc-main-title pb-0">
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

            <?php if(!empty($vision_cards)):?>
                <div class="vision-container">
                    <!-- FIXED TIMELINE -->
                    <div class="vision-timeline"></div>

                    <!-- SCROLLABLE WRAPPER -->
                    <div class="vision-scroll">
                        <?php foreach ($vision_cards as $vision_card): ?>
                            <div class="vision-card">
                                <div class="vision-card-inner">

                                    <?php if(!empty($vision_card['icon'])): ?>
                                        <div class="vision-icon">
                                            <img src="<?php echo $vision_card['icon']; ?>" alt="">
                                        </div>
                                    <?php endif; ?>

                                    <?php if(!empty($vision_card['title'])): ?>
                                        <h6 class="vision-card-title"><?php echo $vision_card['title']; ?></h6>
                                    <?php endif; ?>

                                    <?php if(!empty($vision_card['description'])): ?>
                                        <p class="vision-card-desc pb-0"><?php echo $vision_card['description']; ?></p>
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