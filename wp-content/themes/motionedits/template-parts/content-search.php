<?php

/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package motionedits
 */

?>
<?php
// Skip 'our_portfolio' posts
if ( 'our_portfolio' === get_post_type() ) {
    return; // don't show this post in this template
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('col-sm-6 col-lg-4'); ?>>
	<div class="content-wrap">
		<div class="images-container">
			<?php if (has_post_thumbnail()) : ?>
				
				<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php
					the_post_thumbnail(
						'post-thumbnail',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
					?>
				</a>
				<?php /* motionedits_post_thumbnail()*/; ?>
			<?php else: ?>
				<div class="post-thumbnail">
					<img src="<?php echo get_template_directory_uri(); ?>/images/default-image.png" alt="">
				</div>
			<?php endif; ?>
			<div class="content-title">
				<!-- <?php the_permalink(); ?> -->
				<h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
				<div class="meta">
					<span class="date"><?php echo get_the_date('M j, Y'); ?></span>
				</div>
			</div>
		</div>
	</div>
</article>