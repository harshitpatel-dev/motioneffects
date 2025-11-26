<?php
$section_id = get_sub_field('section_id');
$custom_class = get_sub_field('custom_class');
$section_bg_color = get_sub_field('bg_color');
$show_elements = get_sub_field('show_elements');
$columns_title = get_sub_field('columns_title');
$description = get_sub_field('description');
?>
<section class="two-column-content motion-wrap <?php echo $custom_class; ?>" <?= !empty($section_id) ? 'id="' . htmlspecialchars($section_id) . '"' : '' ?> style="background-color: <?php echo $section_bg_color ?>;">
		<div class="motion-container">
			<div class="two-column-content-wrapper">
				<?php if (in_array('Title', $show_elements)): ?>
					<!-- <div class="motion-container"> -->
						<div class="column-sub-desc-main-title">
							<div class="column-main-title <?php if (in_array('Description', $show_elements)): ?>description<?php endif; ?>">
								<?php if (in_array('Title', $show_elements)): ?>
									<h3 class="title"><?php echo $columns_title; ?></h3>
								<?php endif; ?>
							</div>

							<?php if (in_array('Description', $show_elements)): ?>
								<div class="desc text-center">
									<?php echo $description; ?>
								</div>
							<?php endif; ?>
						</div>
					<!-- </div> -->
				<?php endif; ?>
				<!-- Multi Column -->
				<?php if (get_sub_field('columns')): ?>
					<div class="multi_columns">
						<div class="multi_columns_content">
							<div class="video_image_content row justify-content-center">

								<?php
								$columns = get_sub_field('columns'); // Get the columns repeater field
							
								$column_count = count($columns); // Count the number of columns
								
								// Loop through columns
								foreach ($columns as $column):
									$custom_class = $column['custom_class'];
									$column_class = is_array($column['column_class'])
										? implode(' ', $column['column_class'])
										: $column['column_class'];
									$items = $column['items'];
									?>

									<?php if ($items): ?>
										<div class="column-items <?php echo esc_attr($column_class); ?> <?php echo esc_attr($custom_class); ?>">
											<div class="content-wrap h-100">
												<?php foreach ($items as $item):
													$type = $item['type'];
													$title = $item['title'];
													$sub_title = $item['sub_title'];
													$image = $item['image'];
													// $video_sources = $item['video_source'];
													$text = $item['text'];
													$show_rotate = $item['show_rotate'];
													$buttons = $item['buttons'];
													$contact_details = $item['contact_details'];
													$social_icons = $item['social_icons'];
													$contact_form = $item['contact_form'];
													$grid = $item['grid'];
													$grid_type = $item['grid_type'];
													$desktop_slider = $item['desktop_slider'];
													$process_steps = $item['process_steps'];
													?>
													<?php if ($type === "Sub Title"): ?>
														<div class="item">
															<?php if ($sub_title): ?>
																<h3><?php echo $sub_title; ?></h3>
															<?php endif; ?>
														</div>
													<?php elseif ($type === "Title"): ?>
														<div class="item">
															<?php if ($title): ?>
																<h3 class="title"><?php echo $title; ?></h3>
															<?php endif; ?>
														</div>
													<?php elseif ($type === "Image"): ?>
														<div class="item h-100">
															<div class="item_image">
																<img src="<?php echo esc_url($image); ?>" alt="">
															</div>
														</div>
													<?php elseif ($type === "Text"): ?>
														<div class="item">
															<div class="description"><?php echo $text; ?></div>
														</div>
													<?php elseif ($type === "Button"): ?>
														<div class="item">
															<?php if ($buttons): ?>
																<?php if ($show_rotate): ?>
																
																	<div class="button_section rotation-mobile">
																		<?php
																		foreach ($buttons as $button):
																			$button_link = $button['button_url'];
																			$button_name = $button['button_name'];
																			$btn_class = $button['btn_class'];
																		?>
																			<a href="<?php echo $button_link; ?>" class="btn <?php echo $btn_class; ?>">
																				<?php echo $button_name; ?>
																			</a>
																		<?php endforeach; ?>
																	</div>
																	<div class="button_section pt-0 rotation-desktop">
																		<?php
																		foreach ($buttons as $button):
																			$button_link = $button['button_url'];
																			$button_name = $button['button_name'];
																		?>
																			<a href="<?php echo $button_link; ?>">
																				<div class="circle-btn style3">
																					<svg viewBox="0 0 150 150" class="svg-hidden">
																						<path id="about-tbn" d="M 0,75 a 75,75 0 1,1 0,1 z"></path>
																					</svg>
																					<div class="btn-icon"><img fetchpriority="high" loading="eager" src="<?php echo get_template_directory_uri(); ?>/images/phone-icon.svg" alt=""></div>
																					<div class="btn-text">
																						<svg viewBox="0 0 150 150">
																							<text>
																								<textPath href="#about-tbn"><?php echo $button_name; ?>&nbsp;.&nbsp;<?php echo $button_name; ?>&nbsp.&nbsp;<?php echo $button_name; ?>&nbsp;.&nbsp;</textPath>
																							</text>
																						</svg>
																					</div>
																				</div>
																			</a>
																		<?php endforeach; ?>
																	</div>
																<?php else : ?>
																	<div class="button_section">    
																		<?php 
																		foreach ($buttons as $button):  
																			$button_link = $button['button_url']; 
																			$button_name = $button['button_name'];
																			$btn_class = $button['btn_class'];
																		?>                                                                     
																			<a href="<?php echo $button_link; ?>" class="btn <?php echo $btn_class; ?>">
																				<?php echo $button_name; ?>
																			</a> 
																		<?php endforeach; ?>                                         
																	</div>
																<?php endif; ?>
															<?php endif; ?>
														</div>
													<?php elseif ($type === "Contact Details"): ?>
														<div class="item">
															<ul class="contactDetail">
																<?php if (!empty($contact_details)) : ?>
																	<?php foreach ($contact_details as $detail) : 
																		$detail_type = $detail['type'];
																	?>
																		<?php if ($detail_type === 'Email' && !empty($detail['email'])) : ?>
																			<li class="email">
																				<p class="detail-title">Email:</p>
																				<a href="mailto:<?php echo esc_attr($detail['email']); ?>" title="<?php echo esc_attr($detail['email']); ?>">
																					<?php echo esc_html($detail['email']); ?>
																				</a>
																			</li>

																		<?php elseif ($detail_type === 'Phone' && !empty($detail['phone'])) : ?>
																			<li class="phone">
																				<p class="detail-title">Phone:</p>
																				<a href="tel:<?php echo esc_attr($detail['phone']); ?>" title="<?php echo esc_attr($detail['phone']); ?>">
																					<?php echo esc_html($detail['phone']); ?>
																				</a>
																			</li>
																			
																			<?php elseif ($detail_type === 'Address' && !empty($detail['address'])) : ?>
																			<li class="address">
																				<p class="detail-title">Address:</p>
																				<?php echo $detail['address']; ?>
																			</li>
																		<?php endif; ?>
																	<?php endforeach; ?>
																<?php else: ?>
																	<?php // echo 'No contact details found'; ?>
																<?php endif; ?>
															</ul>
														</div>
													<?php elseif ($type === "Social Icons"): ?> 
														<div class="item">
															<div class="social-details">
																<div class="detail-title">Follow us:</div>
																<ul class="socialMenu">
																	<?php if (!empty($social_icons)) : ?>
																		<?php foreach ($social_icons as $icon) : 
																			$menu_label = $icon['menu_label'];
																			$menu_link  = $icon['menu_link'];
																		?>
																			<?php if ($menu_label === 'Facebook' && !empty($menu_link)) : ?>
																				<li>
																					<a href="<?php echo esc_url($menu_link); ?>" title="<?php echo esc_attr($menu_label); ?>" target="_blank">
																						<span class="imgs"><i class='bx bxl-facebook'></i></span>
																					</a>
																				</li>

																			<?php elseif ($menu_label === 'Instagram' && !empty($menu_link)) : ?>
																				<li>
																					<a href="<?php echo esc_url($menu_link); ?>" title="<?php echo esc_attr($menu_label); ?>" target="_blank">
																						<span class="imgs"><i class='bx bxl-instagram'></i></span>
																					</a>
																				</li>

																			<?php elseif ($menu_label === 'Linkedin' && !empty($menu_link)) : ?>
																				<li>
																					<a href="<?php echo esc_url($menu_link); ?>" title="<?php echo esc_attr($menu_label); ?>" target="_blank">
																						<span class="imgs"><i class='bx bxl-linkedin'></i></span>
																					</a>
																				</li>

																			<?php elseif ($menu_label === 'Vimeo' && !empty($menu_link)) : ?>
																				<li>
																					<a href="<?php echo esc_url($menu_link); ?>" title="<?php echo esc_attr($menu_label); ?>" target="_blank">
																						<span class="imgs"><i class='bx bxl-vimeo'></i></span>
																					</a>
																				</li>
																			<?php endif; ?>

																		<?php endforeach; ?>
																	<?php else: ?>
																		<?php // echo 'No social icons found'; ?>
																	<?php endif; ?>
																</ul>
															</div>
														</div>
			
													<?php elseif ($type === "Contact Form"): ?> 
														<div class="item">
															<div class="contact-section">
																<?php echo $contact_form; ?>
															</div>	
														</div>
													<?php elseif ($type === "Grid"): ?>
														<?php if($grid): ?>
															<div class="grid_column item">
																<div class="grid_column_columns">
																	<?php
																		// Set default values
																		$slider_class = '';
																		$width = ($grid_type === 'Text Title Grid') 
																			? 'col-sm-6 col-md-4 col-lg-6 col-xl-6'
																			: 'col-sm-6 col-lg-4 col-xl-4';

																		// Apply slider class only if it's a Text Title Grid and desktop slider is enabled
																		if ($grid_type === 'Text Title Grid' && $desktop_slider) {
																			$width = 'col-sm-6 col-lg-4 col-xl-3';
																			$slider_class = 'inner-column-slider ';
																		}elseif($grid_type === 'Text Title Grid' && !$desktop_slider){
																			// $width = 'col-sm-6 col-lg-4 col-xl-3';
																			$slider_class = 'mobile-column-slider ';
																			$mobile_slider_column = 'true';
																		}

																		$grid_count = count($grid);
																		$grid_odd_class = ($grid_count % 2 !== 0) ? ' odd-grid' : '';
																	?>

																	<div class="row justify-content-center <?php echo $grid_odd_class;?> <?php echo $slider_class?>">
																		<?php foreach ($grid as $value): ?>
																			<?php
																				$image = $value['icon'] ?? '';
																				$title = $value['title'] ?? '';
																				$description = $value['description'] ?? '';
																				$text_title = $value['text_title'] ?? '';
																				$grid_show_rotate = $value['show_rotate'];
																				$grid_buttons = $value['buttons'];
																				$grid_show_button = $value['show_button'];

																				if($grid_show_button): $width .= ' button-grid'; endif;
																			?>
																			<div class="grid <?php echo $width; ?>">
																				<div class="grid_column_columns-inner content-wrap">
																					<?php if (!empty($title) || !empty($text_title)): ?>
																						<div class="content-titles">
																							<?php if ($image && $grid_type == "Image Grid"): ?>
																								<div class="iconWrap">
																									<img fetchpriority="high" loading="eager" src="<?php echo esc_url($image); ?>" alt="">
																								</div>
																							<?php endif; ?>
																							<?php if ($text_title && $grid_type == "Text Title Grid"): ?>
																								<h3 class="text_title"><?php echo $text_title; ?></h3>
																							<?php endif; ?>
																							<?php if ($title): ?>
																								<h6 class="title"><?php echo $title; ?></h6>
																							<?php endif; ?>
																						</div>
																					<?php endif; ?>
																					<?php if ($description): ?>
																						<div class="content-description">
																							<?php echo wp_kses_post($description); ?>
																						</div>
																						<?php endif; ?>
																					<?php if ($grid_show_button): ?>
																						<?php ob_start(); ?>
																							<div class="grid_button item">
																								<?php if ($grid_buttons): ?>
																									<?php if ($grid_show_rotate): ?>
																									
																										<div class="button_section rotation-mobile">
																											<?php
																												$grid_button_link = $grid_buttons['button_url'];
																												$grid_button_name = $grid_buttons['button_name'];
																												$grid_btn_class = $grid_buttons['btn_class'];
																											?>
																												<a href="<?php echo $grid_button_link; ?>" class="btn <?php echo $grid_btn_class; ?>">
																													<?php echo $grid_button_name; ?>
																												</a>
																										</div>
																										<div class="button_section pt-0 rotation-desktop">
																											<?php
																												$grid_button_link = $grid_buttons['button_url'];
																												$grid_button_name = $grid_buttons['button_name'];
																											?>
																												<a href="<?php echo $grid_button_link; ?>">
																													<div class="circle-btn style3">
																														<svg viewBox="0 0 150 150" class="svg-hidden">
																															<path id="about-tbn" d="M 0,75 a 75,75 0 1,1 0,1 z"></path>
																														</svg>
																														<div class="btn-icon"><img fetchpriority="high" loading="eager" src="<?php echo get_template_directory_uri(); ?>/images/phone-icon.svg" alt=""></div>
																														<div class="btn-text">
																															<svg viewBox="0 0 150 150">
																																<text>
																																	<textPath href="#about-tbn"><?php echo  $grid_button_name; ?>&nbsp;.&nbsp;<?php echo  $grid_button_name; ?>&nbsp.&nbsp;<?php echo  $grid_button_name; ?>&nbsp;.&nbsp;</textPath>
																																</text>
																															</svg>
																														</div>
																													</div>
																												</a>
																										</div>
																									<?php else : ?>
																										<div class="button_section">
																											<?php 
																												$grid_button_link = $grid_buttons['button_url']; 
																												$grid_button_name = $grid_buttons['button_name'];
																												$grid_btn_class = $grid_buttons['btn_class'];
																											?>    
																												<a href="<?php echo $grid_button_link; ?>" class="btn <?php echo $grid_btn_class; ?>">
																													<?php echo $grid_button_name; ?>
																												</a> 
																										</div>
																									<?php endif; ?>
																								<?php endif; ?>
																							</div>
																						<?php echo $button_html = ob_get_clean(); ?>
																					<?php endif; ?>
																				</div>
																			</div>
																		<?php endforeach;?>
																	</div>
																</div>
															</div>
															<?php if($button_html): ?>
																<div class="mobile-button-wrapper d-block d-lg-none">
																	<?php echo $button_html; ?>
																</div>
															<?php endif; ?>

														<?php endif; ?>

													<?php elseif ($type === "Process Steps"): ?>
														<?php if (!empty($process_steps) && is_array($process_steps)): ?>
															<div class="process-steps-wrapper">
																<span class="process-timeline"></span>
																<div class="process-steps">
																	<?php 
																	$row_index = 1;
																	foreach ($process_steps as $process_step):
																		$icon = $process_step['step_icon'];
																		$title = $process_step['step_title'];
																		$desc = $process_step['step_description'];
																	?>
																	<div class="process-card">
																		<div class="process-card-inner">
																			<div class="process-icon">
																				<?php if( !empty($icon) ): ?>
																					<img src="<?php echo esc_url($icon); ?>" alt="<?php echo esc_attr($title); ?>">
																				<?php endif; ?>
																			</div>

																			<div class="process-content">
																				<h5><?php echo esc_html($title); ?></h5>
																				<p><?php echo esc_html($desc); ?></p>
																			</div>

																			<div class="process-number">
																				<?php echo esc_html($row_index); ?>
																			</div>
																		</div>
																	</div>
																	<?php $row_index++; endforeach; ?>
																</div>
															</div>
														<?php endif; ?>

													<?php endif; $column_count++; ?>
												<?php endforeach; ?>
											</div>
										</div>
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				<?php else: ?>
					<?php // No rows found ?>
				<?php endif; ?>
			</div>
		</div>
	</section>


<?php if($mobile_slider_column):?>
	<script>
		jQuery(document).ready(function($){

			function initToolsMobileSlider(){
				var slider = $('.mobile-column-slider');

				if(window.innerWidth <= 991){
					if(!slider.hasClass('slick-initialized')){
						slider.slick({
							slidesToShow: 2,
							slidesToScroll: 1,
							dots: false,
							arrows: false,
							autoplay: true,
							responsive: [
								{
									breakpoint: 767,
									settings: {
										slidesToShow: 2,
										slidesToScroll: 1,
									}
								},
								{
									breakpoint: 576,
									settings: {
										slidesToShow: 1,
										slidesToScroll: 1,
									}
								}
							]
						});
					}
				} else {
					if(slider.hasClass('slick-initialized')){
						slider.slick('unslick');
					}
				}
			}

			initToolsMobileSlider();
			$(window).on('resize', initToolsMobileSlider);

		});
	</script>
<?php endif; ?>