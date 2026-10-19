<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package motionedits
 */

?>
	<footer id="colophon" class="site-footer">
		<div class="footer-top">
			<div class="motion-container">
				<div class="row">
					<div class="footerlogo-contactdetail col-xl-7 col-md-6">
						<div class="footerlogoWrap">
							<?php $logo = get_field( 'logo', 'option' ); ?>
							<?php if ( $logo ) :
								$logo_width  = $logo['width'];
								$logo_height = $logo['height'];
								if ( empty( $logo_width ) || empty( $logo_height ) ) {
									// ACF/WP always reports width/height as 0 for SVGs (it
									// doesn't parse SVG internals) - read the real dimensions
									// from the file itself, same helper used for icon SVGs
									// elsewhere in this theme.
									list( $logo_width, $logo_height ) = motionedits_get_svg_dimensions( $logo['url'] );
								}
							?>
								<img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo esc_attr( $logo['alt'] ); ?>" <?php if ( ! empty( $logo_width ) && ! empty( $logo_height ) ) : ?>width="<?php echo esc_attr( $logo_width ); ?>" height="<?php echo esc_attr( $logo_height ); ?>"<?php endif; ?> loading="lazy" />
							<?php endif; ?>
						</div>
						<?php if ( have_rows( 'contact_detail', 'option' ) ) : ?>
							<ul class="contactDetail">
								<?php while ( have_rows( 'contact_detail', 'option' ) ) : the_row(); 
									$type = get_sub_field( 'type' );
								?>
									<?php if($type == 'Email') : ?>
										<li class="email">
											<a href="mailto:<?php the_sub_field( 'email' ); ?>" title="<?php the_sub_field( 'email' ); ?>">
												<span class="imgs"><img src="<?php echo get_template_directory_uri();?>/images/email-footer.svg" alt=""></span>			
												<span><?php the_sub_field( 'email' ); ?></span>
											</a>
										</li>
									<?php endif; ?>
									<?php if($type == 'Phone') : ?>
										<li class="phone">
											<a href="tel:<?php the_sub_field( 'phone' ); ?>" title="<?php the_sub_field( 'phone' ); ?>">
												<span class="imgs"><img src="<?php echo get_template_directory_uri();?>/images/phone-footer.svg" alt=""></span>
												<span><?php the_sub_field( 'phone' ); ?></span>
											</a>
										</li>
									<?php endif; ?>
									<?php if($type == 'Address') : ?>
										<li class="address">
											<?php the_sub_field( 'address' ); ?>
										</li>
									<?php endif; ?>
								<?php endwhile; ?>

							</ul>
						<?php endif; ?>
						<?php if ( have_rows( 'add_links', 'option' ) ) : ?>
							<ul class="socialMenu">
								<?php while ( have_rows( 'add_links', 'option' ) ) : the_row(); 
									$menu_label = get_sub_field( 'menu_label' );
								?>
									<?php if($menu_label == 'Facebook') : ?>
										<li>
											<a href="<?php the_sub_field( 'menu_link' ); ?>" title="<?php the_sub_field( 'menu_label' ); ?>" target="_blank">
												<!-- <span class="imgs"><img src="<?php //echo get_template_directory_uri();?>/images/facebook.svg" alt=""></span> -->
												<span class="imgs"><i class='bx bxl-facebook'></i></span>
											</a>
										</li>
									<?php endif; ?>
									<?php if($menu_label == 'Instagram') : ?>
										<li>
											<a href="<?php the_sub_field( 'menu_link' ); ?>" title="<?php the_sub_field( 'menu_label' ); ?>" target="_blank">
												<!-- <span class="imgs"><img src="<?php echo get_template_directory_uri();?>/images/instagram.svg" alt=""></span> -->
												<span class="imgs"><i class='bx bxl-instagram' ></i></span>
											</a>
										</li>
									<?php endif; ?>
									<?php if($menu_label == 'Linkedin') : ?>
										<li>
											<a href="<?php the_sub_field( 'menu_link' ); ?>" title="<?php the_sub_field( 'menu_label' ); ?>" target="_blank">
												<!-- <span class="imgs"><img src="<?php echo get_template_directory_uri();?>/images/linkedin.svg" alt=""></span> -->
												<span class="imgs"><i class='bx bxl-linkedin'></i></span>

											</a>
										</li>
									<?php endif; ?>
									<?php if($menu_label == 'Vimeo') : ?>
										<li>
											<a href="<?php the_sub_field( 'menu_link' ); ?>" title="<?php the_sub_field( 'menu_label' ); ?>" target="_blank">
												<!-- <span class="imgs"><img src="<?php echo get_template_directory_uri();?>/images/youtube.svg" alt=""></span> -->
												<span class="imgs"><i class='bx bxl-vimeo' ></i></span>
											</a>
										</li>
									<?php endif; ?>
								<?php endwhile; ?>
							</ul>
						<?php endif; ?>
					</div>
					<div class="add-menu-wrap col-xl-5 col-md-6">
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<?php if ( have_rows( 'add_menu', 'option' ) ) : ?>
									<div class="footer-menu-wrap">
										<?php while ( have_rows( 'add_menu', 'option' ) ) : the_row(); ?>
											<div class="footer-menu">
												<!-- <h5><?php the_sub_field( 'title' ); ?><i class='bx bx-chevron-down'></i></h5> -->
												<h5><?php the_sub_field( 'title' ); ?><span class="dropdown"><img src="<?php echo get_template_directory_uri();?>/images/footer-dropdown.svg" alt="dropdown"> </span></h5>
												<?php the_sub_field( 'select_menu' ); ?>
											</div>
										<?php endwhile; ?>
									</div>
								<?php endif; ?>		
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="footer-bottom">
			<div class="motion-container">
				<div class="copy-right">
					<?php 
						$copyright_text = get_field( 'text' , 'option' );
						$copyright = str_replace('[year]', date('Y'), $copyright_text);
					?>
					<div class="content"><?php echo $copyright; ?></div>
					<div class="footer-bottom__menu">
						<?php $support_link = get_field( 'support_link', 'option' ); ?>
						<?php if ( $support_link ) : ?>
							<?php echo $support_link; ?>
						<?php endif; ?>	
					</div>
				</div>
				
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
