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
?>

<section class="testimonials motion-wrap <?php echo esc_attr($custom_class); ?>" style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="motion-container">
        <div class="grid_column">
            <?php if(in_array('Title', $show_elements) || in_array('Description', $show_elements)) : ?>
                <div class="column-sub-desc-main-title">
                    <div class="row">
                        <div class="column-main-title <?php if(in_array('Description', $show_elements)): ?>description<?php endif; ?>">
                            <?php if(in_array('Title', $show_elements)) : ?>
                                <h3 class="title"><?php echo $title; ?></h3>
                            <?php endif; ?>

                            <?php if(in_array('Description', $show_elements)) : ?>
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

    <?php if ( $show_video && $show_options== 'videos' && !empty( $video_items ) && is_array( $video_items ) ) : ?>
        <div class="testimonials-video-wrapper">
            <div class="testimonial-video-slider">
                <?php foreach ( $video_items as $video_item ) :
                    $video_type   = $video_item['video_type'];
                    $thumbnail    = $video_item['thumbnail'];
                    $video_link   = trim( $video_item['video_link'] );
                    $video_file   = $video_item['video_file'];
                    $name         = $video_item['name'];
                    $designation  = $video_item['designation'];

                    // Convert video links to embeddable format
                    $embed_url = '';
                    if ( $video_type === 'Link' ) {
                        // YouTube short URL (youtu.be)
                        if ( strpos( $video_link, 'youtu.be/' ) !== false ) {
                            $video_id = basename( parse_url( $video_link, PHP_URL_PATH ) );
                            $embed_url = 'https://www.youtube.com/embed/' . $video_id;
                        } 
                        // YouTube full URL (youtube.com/watch)
                        elseif ( strpos( $video_link, 'youtube.com/watch?v=' ) !== false ) {
                            parse_str( parse_url( $video_link, PHP_URL_QUERY ), $params );
                            if ( isset( $params['v'] ) ) {
                                $embed_url = 'https://www.youtube.com/embed/' . $params['v'];
                            }
                        }
                        // YouTube Shorts URL
                        elseif ( strpos( $video_link, 'youtube.com/shorts/' ) !== false ) {
                            preg_match( '/shorts\/([a-zA-Z0-9_-]+)/', $video_link, $matches );
                            if ( ! empty( $matches[1] ) ) {
                                $embed_url = 'https://www.youtube.com/embed/' . $matches[1];
                            }
                        }
                        // Vimeo
                        elseif ( strpos( $video_link, 'vimeo.com/' ) !== false ) {
                            $video_id = basename( parse_url( $video_link, PHP_URL_PATH ) );
                            $embed_url = 'https://player.vimeo.com/video/' . $video_id;
                        }
                        // Fallback for other links
                        else {
                            $embed_url = $video_link;
                        }
                    } elseif ( $video_type === 'File' ) {
                        $embed_url = esc_url( $video_file );
                    }

                    // Thumbnail logic
                    $thumb_url = '';
                    if ( is_array( $thumbnail ) && ! empty( $thumbnail['url'] ) ) {
                        $thumb_url = esc_url( $thumbnail['url'] );
                    } elseif ( is_string( $thumbnail ) && ! empty( $thumbnail ) ) {
                        $thumb_url = esc_url( $thumbnail );
                    }

                    // Extract video ID for dynamic thumbnail generation
                    $video_id = '';
                    if ( empty( $thumb_url ) ) {
                        if ( strpos( $embed_url, 'youtube.com/embed/' ) !== false ) {
                            preg_match( '/embed\/([a-zA-Z0-9_-]+)/', $embed_url, $matches );
                            $video_id = ! empty( $matches[1] ) ? $matches[1] : '';
                        } elseif ( strpos( $embed_url, 'player.vimeo.com/video/' ) !== false ) {
                            preg_match( '/video\/(\d+)/', $embed_url, $matches );
                            $video_id = ! empty( $matches[1] ) ? $matches[1] : '';
                        }
                    }
                ?>
                <div class="testimonial-grid px-2">
                    <div class="testimonial-video-card"
                        data-bs-toggle="modal"
                        data-bs-target="#testimonialVideoModal"
                        data-type="<?php echo esc_attr( $video_type ); ?>"
                        data-src="<?php echo esc_attr( $embed_url ); ?>"
                        data-video-id="<?php echo esc_attr( $video_id ); ?>">

                        <div class="testimonial-media">
                            <?php if ( $thumb_url ) : ?>
                                <img src="<?php echo $thumb_url; ?>" alt="<?php echo esc_attr( $name ); ?>" class="img-fluid testimonial-thumb" />
                            <?php elseif ( $video_id && strpos( $embed_url, 'youtube.com' ) !== false ) : ?>
                                <img src="https://img.youtube.com/vi/<?php echo $video_id; ?>/maxresdefault.jpg" 
                                    alt="<?php echo esc_attr( $name ); ?>" 
                                    class="img-fluid testimonial-thumb youtube-thumb"
                                    onerror="this.src='https://img.youtube.com/vi/<?php echo $video_id; ?>/hqdefault.jpg'" />
                            <?php elseif ( $video_id && strpos( $embed_url, 'vimeo.com' ) !== false ) : ?>
                                <img src="" 
                                    alt="<?php echo esc_attr( $name ); ?>" 
                                    class="img-fluid testimonial-thumb vimeo-thumb" 
                                    data-vimeo-id="<?php echo $video_id; ?>" />
                            <?php elseif ( $video_type === 'file' ) : ?>
                                <video class="testimonial-thumb file-video-thumb" muted preload="metadata" style="object-fit: cover;">
                                    <source src="<?php echo esc_url( $video_file ); ?>#t=0.5" type="video/mp4">
                                </video>
                            <?php else : ?>
                                <div class="testimonial-thumb testimonial-thumb--placeholder"></div>
                            <?php endif; ?>
                        </div>

                        <div class="testimonial-info">
                            <span class="play-icon"><i class='bx bx-play'></i></span>
                            <div class="details">
                                <h6 class="testimonial-name"><?php echo esc_html( $name ); ?></h6>
                                <?php if ( $designation ) : ?>
                                    <div class="testimonial-designation"><?php echo esc_html( $designation ); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Bootstrap Modal -->
        <div class="modal fade" id="testimonialVideoModal" tabindex="-1" aria-labelledby="testimonialVideoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-transparent border-0 shadow-none">
                    <button type="button" class="btnclose" data-bs-dismiss="modal" aria-label="Close">
                        <i class='bx bx-x'></i>
                    </button>
                    <div class="ratio ratio-16x9">
                        <div id="testimonial-video-container"></div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            jQuery(document).ready(function($){
                // Load Vimeo thumbnails dynamically
                $('.vimeo-thumb').each(function() {
                    const vimeoId = $(this).data('vimeo-id');
                    const imgElement = $(this);
                    
                    if (vimeoId) {
                        $.ajax({
                            url: 'https://vimeo.com/api/v2/video/' + vimeoId + '.json',
                            dataType: 'json',
                            success: function(data) {
                                if (data && data[0] && data[0].thumbnail_large) {
                                    imgElement.attr('src', data[0].thumbnail_large);
                                }
                            },
                            error: function() {
                                imgElement.replaceWith('<div class="testimonial-thumb testimonial-thumb--placeholder"></div>');
                            }
                        });
                    }
                });

                // Initialize Slick Slider
                $('.testimonial-video-slider').slick({
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: false,
                    autoplay: true,
                    infinite: true,
                    cssEase: 'linear',
                    draggable: false,
                    responsive: [
                        { breakpoint: 1199, settings: { slidesToShow: 4 } },
                        { breakpoint: 991, settings: { slidesToShow: 3 } },
                        { breakpoint: 576, settings: { slidesToShow: 1 } }
                    ]
                });

                // Video modal logic
                const modal = $('#testimonialVideoModal');
                const videoContainer = $('#testimonial-video-container');

                $('.testimonial-video-card').on('click', function() {
                    const videoType = $(this).data('type');
                    const videoUrl = $(this).data('src');

                    if (!videoUrl) return;

                    // Clear container
                    videoContainer.empty();

                    if (videoType === 'file') {
                        // For uploaded video files, use HTML5 video tag
                        const videoElement = $('<video>', {
                            controls: true,
                            autoplay: true,
                            class: 'w-100 h-100',
                            style: 'object-fit: cover;',
                            src: videoUrl
                        });
                        videoContainer.append(videoElement);
                    } else {
                        // For YouTube/Vimeo, use iframe with autoplay
                        let embedUrl = videoUrl;
                        
                        // Add autoplay parameter
                        if (videoUrl.includes('youtube.com/embed/')) {
                            embedUrl = videoUrl + (videoUrl.includes('?') ? '&' : '?') + 'autoplay=1&rel=0';
                        } else if (videoUrl.includes('player.vimeo.com')) {
                            embedUrl = videoUrl + (videoUrl.includes('?') ? '&' : '?') + 'autoplay=1';
                        }

                        const iframe = $('<iframe>', {
                            src: embedUrl,
                            frameborder: 0,
                            allow: 'autoplay; encrypted-media; picture-in-picture',
                            allowfullscreen: true,
                            class: 'w-auto h-100 mx-auto d-block'
                        });
                        videoContainer.append(iframe);
                    }
                });

                // Stop video when modal closes
                modal.on('hidden.bs.modal', function() {
                    videoContainer.empty();
                });
            });
        </script>
    <?php endif; ?>

    <?php if($show_options== 'reviews'): ?>

    <div class="testimonials-inner-wrapper">
		<div class="motion-container">
	      <?php echo do_shortcode($review_short_code); ?>
		</div>
    </div>
    <?php endif;?>


</section>
