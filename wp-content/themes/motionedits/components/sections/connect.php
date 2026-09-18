<?php
$title        = get_sub_field('title');
$description  = get_sub_field('description');
$social_links = get_sub_field('social_links');
$custom_class = get_sub_field('custom_class');
$bg_color     = get_sub_field('bg_color');

$icon_map = [
	'LinkedIn'  => 'bx bxl-linkedin',
	'Vimeo'     => 'bx bxl-vimeo',
	'Instagram' => 'bx bxl-instagram',
	'YouTube'   => 'bx bxl-youtube',
	'Facebook'  => 'bx bxl-facebook',
	'Twitter'   => 'bx bxl-twitter',
];

$animation_delay = 0;
?>

<section class="connect_wrapper motion-wrap <?php echo esc_attr($custom_class); ?>"
	style="background-color: <?php echo esc_attr($bg_color); ?>">
	<div class="motion-container">
		<div class="connect_wrapper-container">

			<?php if ($title || $description) : ?>
				<div class="column-sub-desc-main-title pb-0" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
					<?php $animation_delay += 200; ?>
					<div class="row">
						<div class="column-main-title <?php echo $description ? 'description' : ''; ?>">
							<?php if ($title) : ?>
								<h3 class="title"><?php echo esc_html($title); ?></h3>
							<?php endif; ?>

							<?php if ($description) : ?>
								<div class="desc"><p><?php echo $description; ?></p></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if (!empty($social_links)) : ?>
				<ul class="connect_links" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
					<?php foreach ($social_links as $link) :
						$platform = $link['platform'];
						$url      = $link['url'];
						$icon     = $icon_map[$platform] ?? 'bx bx-link';

						if (!$url) {
							continue;
						}
					?>
						<li>
							<a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer">
								<span class="icon"><i class="<?php echo esc_attr($icon); ?>"></i></span>
								<span class="label"><?php echo esc_html($platform); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

		</div>
	</div>
</section>
