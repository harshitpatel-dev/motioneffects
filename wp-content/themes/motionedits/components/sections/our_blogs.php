<?php
    $custom_class  = get_sub_field( 'custom_class' );
	$show_elements = get_sub_field( 'show_elements' );
    $title  = get_sub_field( 'title' );
    $description  = get_sub_field( 'description' );
	$button_group = get_sub_field('buttons');
    $bg_color  = get_sub_field( 'bg_color' );
    $show_all_blogs  = get_sub_field( 'show_all_blogs' );
?>
<section class="our_blogs_columWrap <?php echo esc_attr($custom_class); ?>" style="background-color: <?php echo $bg_color ?>;">
	<div class="motion-container">
		<?php if( in_array('Title',$show_elements)) : ?>
			<div class="column-sub-desc-main-title">
				<div class="row">
					<div class="column-main-title <?php if(in_array('Description',$show_elements)): ?>description<?php endif; ?>">
						<?php  if( in_array('Title',$show_elements)) : ?>
							<h3 class="title"><?php echo $title; ?></h3>
						<?php endif; ?>

						<?php  if( in_array('Description',$show_elements)) : ?>
							<div class="desc">
								<?php echo $description;?>
							</div>
						<?php endif; ?>
					</div>	
				</div>
			</div>
		<?php endif; ?>

		<div class="our-blogs">
			<?php
				if ( !is_singular() ) { 
					$blogsposts = new WP_Query( 
						array(  
						'posts_per_page' => 3,
						'post_type' => 'post', 
						'post_status' => 'publish',
						'order' => 'DESC'
						)
					);
				} else {
					$current_post_id = get_the_ID();
					$blogsposts = new WP_Query( 
						array(  
						'posts_per_page' => 3,
						'post_type' => 'post', 
						'post_status' => 'publish',
						'order' => 'DESC',
						'post__not_in' => array( $current_post_id )
						)
					);
				}
			?>
			<?php if ( $blogsposts->have_posts() ) : ?>
				<div class="our-blogs-content row justify-content-center">
					<?php while ( $blogsposts->have_posts() ) : $blogsposts->the_post(); ?>
						<?php
							$post_id = get_the_ID();
						?>
						<div class="our-blog col-md-4 col-lg-4">
							<div class="content-wrap">
								<a href="<?php the_permalink(); ?>" class="img-link">
									<div class="images-contener">
										<div class="imgs">
											<?php if ( has_post_thumbnail() ) { 
												the_post_thumbnail( get_the_ID(), 'full' );
											} ?>
										</div>
										<div class="meta">
											<span class="date"><?php echo get_the_date( 'F j, Y' ); ?></span>
										</div>
									</div>
									<div class="content">
										<h6 class="title"><?php the_title(); ?></h6>
										<div class="short-desc"><?php the_excerpt(); ?></div>
										<div class="buttons">
											<a href="<?php the_permalink();?>" class="btn-readmore"> Read More <span> <img src="<?php echo get_template_directory_uri(); ?>/images/right-arrow.svg" alt="button-arrow"></span></a>
										</div>
									</div>
								</a>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
			<?php endif; 
			wp_reset_postdata(); 
			?>
		</div>

		<!-- Buttons -->
		<div class="blogs-buttons">
		<?php while (have_rows('buttons')) :  the_row();
			$button_link = get_sub_field('link');
			$link_url = $button_link['url'] ?? '#';
			$button_name = get_sub_field('label');
			$link_target = $button_link['target'] ?? '_self';
			$button_class = get_sub_field('btn_class');
		?>
			<?php if($button_name):?>
				<div class="buttons">
					<a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" class="btn <?php echo $button_class; ?>"><?php echo $button_name; ?></a>
				</div>
			<?php endif; ?>
		<?php endwhile; ?>
		</div>

	</div>
</section>