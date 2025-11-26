<?php
	$heroTitle = get_sub_field('title');
	$herosub_title = get_sub_field('sub_title');
	$heroDesp = get_sub_field('description');
	$show_options = get_sub_field('show_options');
	$trusted_by = get_sub_field('trusted_by');
	$about_company = get_sub_field('about_company');
	$bgColor = get_sub_field('bg_color');
    $custom_class  = get_sub_field('custom_class');
?>
<div class="heroBanner_wrap <?php echo $custom_class; ?>" style="background-color: <?php echo $bgColor; ?>;">
	<div class="heroBanner">
		<div class="motion-container">
			<div class="heroBanner__innrer">
					
				<?php if($heroTitle):?>
					<div class="heroBanner__content">
						<?php if($herosub_title):?>
							<div class="heroBanner__content-subtitle">
								<span><?php echo $herosub_title; ?></span>
							</div>
						<?php endif; ?>
						<h1 class="heroBanner__content-title" style="display: none;">
							<?php echo $heroTitle; ?>
						</h1>
						<h2 class="heroBanner__content-title">
							<?php echo $heroTitle; ?>
						</h2>
						<?php if($heroDesp):?>
							<div class="heroBanner__content-description">
								<?php echo $heroDesp; ?>
							</div>
						<?php endif; ?>
						<?php if (have_rows('buttons')) : ?>
							<div class="buttons">
								<div class="button-contener">
									<?php while (have_rows('buttons')) :  the_row();
										$button_link = get_sub_field('link');
										$button_name = get_sub_field('label'); 
										$btn_class = get_sub_field('btn_class'); 
									?>
										<?php if($button_name):?>
											<a href="<?php echo $button_link; ?>" class="btn <?php echo $btn_class; ?>"><?php echo $button_name; ?></a>
										<?php endif; ?>
									<?php endwhile; ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>	

				<?php if($show_options == 'Trusted By' && !empty($trusted_by)): ?>
					<?php 
						$trusted_title = $trusted_by['title'];
						$trusted_items = $trusted_by['items'];
						$bgColor = $trusted_by['bg_color'];
					?>
					<div class="heroBanner__trustedBy heroBanner_commanEffect" style="background-color: <?php echo $bgColor; ?>;">
						<div class="heroBanner__trustedBy-inner">
							<?php if ($trusted_title): ?>
								<div class="heroBanner__trustedBy-title_dublicate">
									<div class="heroBanner__trustedBy-titleWrap ">
										<?php for ($i = 0; $i < 2; $i++): ?>
											<div class="heroBanner__trustedBy-title desktop">
												<img src="<?php echo get_template_directory_uri(); ?>/images/star-icon.svg" alt="Star Icon">
												<span><?php echo esc_html($trusted_title); ?></span>
												<img src="<?php echo get_template_directory_uri(); ?>/images/star-icon.svg" alt="Star Icon">
											</div>
										
											<!-- Mobile only stars -->
											<div class="heroBanner__trustedBy-title heroBanner__trustedBy-starsOnly mobile">
												<?php for ($j = 0; $j < 3; $j++): ?>
													<img src="<?php echo get_template_directory_uri(); ?>/images/star-icon.svg" alt="Star Icon">
												<?php endfor; ?>
											</div>
										<?php endfor; ?>
										
									</div>
								</div>
							<?php endif; ?>


							<?php if($trusted_items): ?>
							<!-- <div class="motion-container"> -->
								<div class="heroBanner__trustedBy-slider">
									<?php foreach($trusted_items as $trusted_item): ?>
									<div class="heroBanner__trustedBy-item">
										<div class="img-wrapper">
											<img src="<?php echo $trusted_item['image']['url']; ?>" alt="<?php echo esc_attr($trusted_item['image']['alt']); ?>">
										</div>
									</div>
									<?php endforeach; ?>
								</div>
							<!-- </div> -->
							<?php endif; ?>
						</div>
					</div>
				
				<?php elseif($show_options == 'About Company' && !empty($about_company)): ?>
					<?php 
						$company_items = $about_company['items'];
						$bgColor = $about_company['bg_color'];
					?>
					<div class="heroBanner__about heroBanner_commanEffect" style="background-color: <?php echo $bgColor; ?>;">
						<div class="heroBanner__about-inner">
							
							<?php if($company_items): ?>
								<div class="heroBanner__about-slider">
									<?php foreach($company_items as $company_item): ?>
									<div class="heroBanner__about-item">
										<?php if(!empty($company_item['title'])): ?>
											<div class="item-wrapper">
													<h3 class="title">
														<?php echo $company_item['title']; ?>
													</h3>
												<?php if(!empty($company_item['description'])): ?>
													<div class="desc">
														<?php echo $company_item['description']; ?>
													</div>
												<?php endif;?>
											</div>
										<?php endif;?>
									</div>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
</div>