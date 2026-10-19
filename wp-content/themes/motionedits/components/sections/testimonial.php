<?php
$show_elements = get_sub_field('show_elements');
$title = get_sub_field('title'); 
$description = get_sub_field('description');
$show_video = get_sub_field('show_videos');
$show_options= get_sub_field('show_options');
$video_items = get_sub_field('video_items');
$review_short_code = get_sub_field('review_short_code');
$bg_color = get_sub_field('bg_color');
$custom_class = get_sub_field('custom_class');
// animation delay counter (ms)
$animation_delay = 0;
?>

<section class="testimonials motion-wrap <?php echo esc_attr($custom_class); ?>"
    style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="motion-container">
        <div class="grid_column">
            <?php if (in_array('Title', $show_elements) || in_array('Description', $show_elements)): ?>
                <div class="column-sub-desc-main-title" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                    <?php $animation_delay += 200; ?>
                    <div class="row">
                        <div
                            class="column-main-title <?php if (in_array('Description', $show_elements)): ?>description<?php endif; ?>">
                            <?php if (in_array('Title', $show_elements)): ?>
                                <h3 class="title"><?php echo $title; ?></h3>
                            <?php endif; ?>

                            <?php if (in_array('Description', $show_elements)): ?>
                                <div class="desc">
                                    <p><?php echo $description; ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($show_video && $show_options == 'videos' && !empty($video_items) && is_array($video_items)): ?>
        <div class="testimonials-video-wrapper">
            <div class="testimonial-video-slider">
                <?php foreach ($video_items as $index => $video_item):
                    $video_type = $video_item['video_type'];
                    $thumbnail = $video_item['thumbnail'];
                    $video_link = trim($video_item['video_link']);
                    $video_file = $video_item['video_file'];
                    $name = $video_item['name'];
                    $designation = $video_item['designation'];

                    // Convert video links to embeddable format
                    $embed_url = '';
                    if ($video_type === 'Link') {
                        // YouTube short URL (youtu.be)
                        if (strpos($video_link, 'youtu.be/') !== false) {
                            $video_id = basename(parse_url($video_link, PHP_URL_PATH));
                            $embed_url = 'https://www.youtube.com/embed/' . $video_id;
                        }
                        // YouTube full URL (youtube.com/watch)
                        elseif (strpos($video_link, 'youtube.com/watch?v=') !== false) {
                            parse_str(parse_url($video_link, PHP_URL_QUERY), $params);
                            if (isset($params['v'])) {
                                $embed_url = 'https://www.youtube.com/embed/' . $params['v'];
                            }
                        }
                        // YouTube Shorts URL
                        elseif (strpos($video_link, 'youtube.com/shorts/') !== false) {
                            preg_match('/shorts\/([a-zA-Z0-9_-]+)/', $video_link, $matches);
                            if (!empty($matches[1])) {
                                $embed_url = 'https://www.youtube.com/embed/' . $matches[1];
                            }
                        }
                        // Vimeo
                        elseif (strpos($video_link, 'vimeo.com/') !== false) {
                            $video_id = basename(parse_url($video_link, PHP_URL_PATH));
                            $embed_url = 'https://player.vimeo.com/video/' . $video_id;
                        }
                        // Fallback for other links
                        else {
                            $embed_url = $video_link;
                        }
                    } elseif ($video_type === 'File') {
                        $embed_url = esc_url($video_file);
                    }

                    // Thumbnail logic
                    $thumb_url = '';
                    if (is_array($thumbnail) && !empty($thumbnail['url'])) {
                        $thumb_url = esc_url($thumbnail['url']);
                    } elseif (is_string($thumbnail) && !empty($thumbnail)) {
                        $thumb_url = esc_url($thumbnail);
                    }

                    // Extract video ID for dynamic thumbnail generation
                    $video_id = '';
                    if (empty($thumb_url)) {
                        if (strpos($embed_url, 'youtube.com/embed/') !== false) {
                            preg_match('/embed\/([a-zA-Z0-9_-]+)/', $embed_url, $matches);
                            $video_id = !empty($matches[1]) ? $matches[1] : '';
                        } elseif (strpos($embed_url, 'player.vimeo.com/video/') !== false) {
                            preg_match('/video\/(\d+)/', $embed_url, $matches);
                            $video_id = !empty($matches[1]) ? $matches[1] : '';
                        }
                    }
                    ?>
                    <div class="testimonial-grid px-2" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                        <?php $animation_delay += 100; ?>
                        <div class="testimonial-video-card" data-type="<?php echo esc_attr($video_type); ?>"
                            data-src="<?php echo esc_attr($embed_url); ?>" data-video-id="<?php echo esc_attr($video_id); ?>"
                            data-card-index="<?php echo $index; ?>">

                            <div class="testimonial-media">
                                <?php if ($thumb_url): ?>
                                    <img src="<?php echo $thumb_url; ?>" alt="<?php echo esc_attr($name); ?>"
                                        class="img-fluid testimonial-thumb" loading="lazy" />
                                <?php elseif ($video_id && strpos($embed_url, 'youtube.com') !== false): ?>
                                    <img loading="lazy" src="https://img.youtube.com/vi/<?php echo $video_id; ?>/maxresdefault.jpg"
                                        alt="<?php echo esc_attr($name); ?>" class="img-fluid testimonial-thumb youtube-thumb"
                                        onerror="this.src='https://img.youtube.com/vi/<?php echo $video_id; ?>/hqdefault.jpg'" />
                                <?php elseif ($video_id && strpos($embed_url, 'vimeo.com') !== false): ?>
                                    <img src="" loading="lazy" alt="<?php echo esc_attr($name); ?>" class="img-fluid testimonial-thumb vimeo-thumb"
                                        data-vimeo-id="<?php echo $video_id; ?>" />
                                <?php elseif ($video_type === 'File'): ?>
                                    <video class="testimonial-thumb file-video-thumb" muted preload="metadata"
                                        style="object-fit: cover;">
                                        <source src="<?php echo esc_url($video_file); ?>#t=0.5" type="video/mp4">
                                    </video>
                                <?php else: ?>
                                    <div class="testimonial-thumb testimonial-thumb--placeholder"></div>
                                <?php endif; ?>
                            </div>

                            <div class="testimonial-info">
                                <span class="play-icon"><i class='bx bx-play'></i></span>
                                <span class="pause-icon"><i class='bx bx-pause'></i></span>
                                <div class="details">
                                    <h6 class="testimonial-name"><?php echo esc_html($name); ?></h6>
                                    <?php if ($designation): ?>
                                        <div class="testimonial-designation"><?php echo esc_html($designation); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    <?php endif; ?>

    <?php if($show_options== 'reviews'): ?>
        <div class="testimonials-inner-wrapper" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
            <?php $animation_delay += 200; ?>
            <div class="motion-container">
            <?php echo do_shortcode($review_short_code); ?>
            </div>
        </div>
    <?php endif;?>

    <?php if($show_options== 'custom-reviews'): ?>
        <?php
            // Query testimonials
            $args = array(
                'post_type' => 'testimonial',
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'DESC'
            );
            $testimonial_query = new WP_Query($args);

            if ($testimonial_query->have_posts()) : ?>
                    <div class="testimonial_slider_wrapper">
                        <div class="testimonials-slider">
                            <?php while ($testimonial_query->have_posts()) : $testimonial_query->the_post();
                                $description = get_field(selector: 'description');
                                $image   = get_field('image');
                                $name = get_field('name');
                                $designation    = get_field(selector: 'designation');
                                ?>
                                <div class="testimonial-card">
                                    <div class="testimonial-gap">
                                        <div class="testimonial-wrapper">
                                            <div class="card-body">
                                                <div class="colun-wrapper">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/images/quotes.svg" alt="quotes">
                                                </div>
                                                <?php if (!empty($description)) : ?>
                                                        <div class="desc"><?php echo wp_kses_post($description); ?></div>
                                                    <?php endif; ?>
                                                <div class="details">
                                                    <?php if (!empty($image)) : ?>
                                                        <div class="image-wrapper">
                                                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($name); ?>">
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="details-text">
                                                        <?php if (!empty($name)) : ?>
                                                            <h6 class="name"><?php echo esc_html($name); ?></h6>
                                                        <?php endif; ?>
                                                        <?php if (!empty($designation)) : ?>
                                                            <span class="designation"><?php echo esc_html($designation); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div class="testimonial-controls">
                            <button class="testimonials-prev-btn"><i class="bx bx-chevron-left"></i></button>
                            <button class="testimonials-next-btn"><i class="bx bx-chevron-right"></i></button>
                        </div>
                    </div>
                <?php wp_reset_postdata();
            endif;?>
    <?php endif; ?>
</section>