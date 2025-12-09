<?php
$show_elements = get_sub_field('show_elements');
$title = get_sub_field('title');
$description = get_sub_field('description');
$video_items = get_sub_field('video_items');
$bg_color = get_sub_field('bg_color');
$custom_class = get_sub_field('custom_class');
?>
<section class="featured_columWrap <?php echo esc_attr($custom_class); ?>"
    style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="motion-container">

        <?php if ($show_elements && in_array('Title', $show_elements)): ?>
            <div class="column-sub-desc-main-title">
                <div class="row">
                    <div
                        class="column-main-title <?php echo in_array('Description', $show_elements) ? 'description' : ''; ?>">

                        <h3 class="title"><?php echo esc_html($title); ?></h3>

                        <?php if (in_array('Description', $show_elements)): ?>
                            <div class="desc">
                                <p><?php echo wp_kses_post($description); ?></p>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($video_items)): ?>
            <div class="featured-videos">
                <div class="featured-videos-content featured-video-slider row justify-content-center">

                    <?php foreach ($video_items as $video_item):
                        $elements = $video_item['show_elements'];
                        $sub_title = $video_item['sub_title'];
                        $video_title = $video_item['title'];
                        $video_desc = $video_item['description'];
                        $video_type = $video_item['video_type'];
                        $thumbnail = $video_item['thumbnail'];
                        $video_url = $video_item['video_url'];
                        $video_file = $video_item['video_file'];

                        // Final video source
                        $feature_video = ($video_type === 'file') ? $video_file : $video_url;
                        $content_class = (!empty($video_title) && !empty($video_desc)) ? '' : 'no-content';
                        ?>

                        <div class="featured-video col-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="content-wrap">

                                <div class="images-contener">
                                    <div class="imgs">
                                        <?php if ($thumbnail) ?>
                                            <img src="<?php echo $thumbnail; ?>"> 
                                    </div>

                                    <?php if (!empty($feature_video)): ?>
                                        <span class="thumbnails-icon" data-bs-toggle="modal" data-bs-target="#featuredVideoModal"
                                            data-video="<?php echo esc_url($feature_video); ?>">
                                            <span class="play-icon"><i class='bx bx-play'></i></span>
                                        </span>
                                    <?php else: ?>
                                        <span class="thumbnails-icon disabled">
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/play-icon-white.svg"
                                                alt="">
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="content <?php echo $content_class; ?>">
                                    <span class="sub_title"><?php echo esc_html($sub_title); ?></span>
                                    <?php if(!empty($content_class)): ?>
                                        <h6 class="title"><?php echo esc_html($video_title); ?></h6>
                                        <div class="short-desc"><?php echo wp_kses_post($video_desc); ?></div>
                                    <?php endif;?>
                                </div>

                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- Video Modal -->
<div class="modal fade" id="featuredVideoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <button type="button" class="btnclose" data-bs-dismiss="modal" aria-label="Close">
                <i class='bx bx-x'></i>
            </button>

            <div class="ratio ratio-16x9">
                <iframe id="featured-video-frame" src="" allow="autoplay; encrypted-media" frameborder="0"
                    allowfullscreen></iframe>
            </div>

        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function ($) {

        const modal = $('#featuredVideoModal');
        const iframe = $('#featured-video-frame');
        const videoSlider = $('.featured-video-slider');

        /* slider */
        if(videoSlider.length){
            videoSlider.slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                dots: false,
                arrows: false,
                autoplay: false,
                responsive: [
                    {
                        breakpoint: 1199,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        }
                    },
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

        $('.thumbnails-icon').on('click', function () {
            const videoUrl = $(this).data('video');
            if (!videoUrl) return;

            let autoplayUrl = videoUrl;

            // Youtube embed conversion
            if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
                autoplayUrl = videoUrl
                    .replace('watch?v=', 'embed/')
                    .replace('youtu.be/', 'youtube.com/embed/')
                    + '?autoplay=1';
            }

            // Vimeo embed conversion
            else if (videoUrl.includes('vimeo.com')) {
                autoplayUrl = videoUrl.includes('player.vimeo.com')
                    ? videoUrl + '?autoplay=1'
                    : videoUrl.replace('vimeo.com', 'player.vimeo.com/video') + '?autoplay=1';
            }

            iframe.attr('src', autoplayUrl);
        });

        modal.on('hidden.bs.modal', function () {
            iframe.attr('src', ''); // Stop video on close
        });
    });

</script>