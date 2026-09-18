<?php

/**
 * The template for displaying Author profile pages
 *
 * Author content is managed via the "Author Layout" ACF field group
 * (flexible content field "sections"), attached to the User edit screen,
 * reusing the same layouts/components as the page builder (see
 * page-template/page-layout.php).
 *
 * @package motionedits
 */

get_header();

$author_id = get_queried_object_id();

if ( $author_id && have_rows( 'sections', 'user_' . $author_id ) ) :
	?>
	<main id="primary" class="site-main">
		<?php
		while ( have_rows( 'sections', 'user_' . $author_id ) ) :
			the_row();
			get_template_part( 'components/sections/' . get_row_layout() );
		endwhile;
		?>
	</main>
	<?php
else :
	?>
	<main id="primary" class="site-main common-page-template-layout">
		<section class="motion-wrap">
			<div class="motion-container">
				<header class="page-header mb-3">
					<h1 class="page-title"><?php the_archive_title(); ?></h1>
				</header>
				<p><?php esc_html_e( 'Comming Soon...', 'motionedits' ); ?></p>
			</div>
		</section>
	</main>
	<?php
endif;

get_footer();
