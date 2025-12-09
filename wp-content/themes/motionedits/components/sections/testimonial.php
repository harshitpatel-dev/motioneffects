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

<section class="testimonials motion-wrap <?php echo esc_attr($custom_class); ?>"
    style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="motion-container">
        <div class="grid_column">
            <?php if (in_array('Title', $show_elements) || in_array('Description', $show_elements)): ?>
                <div class="column-sub-desc-main-title">
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
                    <div class="testimonial-grid px-2">
                        <div class="testimonial-video-card" data-type="<?php echo esc_attr($video_type); ?>"
                            data-src="<?php echo esc_attr($embed_url); ?>" data-video-id="<?php echo esc_attr($video_id); ?>"
                            data-card-index="<?php echo $index; ?>">

                            <div class="testimonial-media">
                                <?php if ($thumb_url): ?>
                                    <img src="<?php echo $thumb_url; ?>" alt="<?php echo esc_attr($name); ?>"
                                        class="img-fluid testimonial-thumb" />
                                <?php elseif ($video_id && strpos($embed_url, 'youtube.com') !== false): ?>
                                    <img src="https://img.youtube.com/vi/<?php echo $video_id; ?>/maxresdefault.jpg"
                                        alt="<?php echo esc_attr($name); ?>" class="img-fluid testimonial-thumb youtube-thumb"
                                        onerror="this.src='https://img.youtube.com/vi/<?php echo $video_id; ?>/hqdefault.jpg'" />
                                <?php elseif ($video_id && strpos($embed_url, 'vimeo.com') !== false): ?>
                                    <img src="" alt="<?php echo esc_attr($name); ?>" class="img-fluid testimonial-thumb vimeo-thumb"
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

        <script>
            jQuery(document).ready(function ($) {
                let currentPlayingCard = null;
                let youtubeAPIReady = false;
                let vimeoAPIReady = false;
                let playerInstances = {}; // keyed by uid + platform, e.g. youtube_vid-abc123

                // 1) Assign stable UID for each card BEFORE Slick clones slides.
                $('.testimonial-video-card').each(function (i) {
                    const $card = $(this);
                    if (!$card.attr('data-uid')) {
                        const uid = 'vid-' + Math.random().toString(36).slice(2, 9);
                        $card.attr('data-uid', uid);
                    }
                });

                // object to hold original thumbnail HTML keyed by uid
                const originalThumbnails = {};

                // Helper to save original thumbnails (store HTML string)
                function saveOriginalThumbnails() {
                    $('.testimonial-video-card').each(function () {
                        const $card = $(this);
                        const uid = $card.attr('data-uid');
                        // find the thumbnail element inside this card
                        const $thumb = $card.find('.testimonial-thumb').first();
                        // store outerHTML string (if thumb exists) or the whole media wrapper HTML
                        if ($thumb.length) {
                            originalThumbnails[uid] = $thumb[0].outerHTML;
                        } else {
                            // fallback: store the current testimonial-media wrapper HTML
                            const $media = $card.find('.testimonial-media').first();
                            originalThumbnails[uid] = $media.length ? $media[0].innerHTML : '<div class="testimonial-thumb testimonial-thumb--placeholder"></div>';
                        }
                    });
                }

                // Load YouTube API (unchanged)
                if (!window.YT) {
                    const tag = document.createElement('script');
                    tag.src = 'https://www.youtube.com/iframe_api';
                    const firstScriptTag = document.getElementsByTagName('script')[0];
                    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                }
                window.onYouTubeIframeAPIReady = function () { youtubeAPIReady = true; };

                // Load Vimeo API (unchanged)
                if (!window.Vimeo) {
                    const vimeoScript = document.createElement('script');
                    vimeoScript.src = 'https://player.vimeo.com/api/player.js';
                    vimeoScript.onload = function () { vimeoAPIReady = true; };
                    document.head.appendChild(vimeoScript);
                }

                // Fetch Vimeo thumbnails as before, but when done, update originalThumbnails for vimeo cards
                $('.vimeo-thumb').each(function () {
                    const $img = $(this);
                    const vimeoId = $img.data('vimeo-id');
                    if (!vimeoId) return;
                    $.ajax({
                        url: 'https://vimeo.com/api/v2/video/' + vimeoId + '.json',
                        dataType: 'json',
                        success: function (data) {
                            if (data && data[0] && data[0].thumbnail_large) {
                                $img.attr('src', data[0].thumbnail_large);
                            }
                        },
                        error: function () {
                            $img.replaceWith('<div class="testimonial-thumb testimonial-thumb--placeholder"></div>');
                        },
                        complete: function () {
                            // after each vimeo thumb completes, re-save original thumbnails for that card
                            // find ancestor card and save its thumbnail HTML
                            const $card = $img.closest('.testimonial-video-card');
                            const uid = $card.attr('data-uid');
                            const $thumb = $card.find('.testimonial-thumb').first();
                            if ($thumb.length) originalThumbnails[uid] = $thumb[0].outerHTML;
                        }
                    });
                });

                // Initialize slick AFTER UIDs are set and vimeo placeholders will be updated as AJAX finishes.
                $('.testimonial-video-slider').slick({
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: false,
                    autoplay: false,
                    autoplaySpeed: 3000,
                    infinite: false,
                    cssEase: 'linear',
                    draggable: false,
                    responsive: [
                        { breakpoint: 1199, settings: { slidesToShow: 4 } },
                        { breakpoint: 991, settings: { slidesToShow: 3 } },
                        { breakpoint: 576, settings: { slidesToShow: 2 } },
                        { breakpoint: 420, settings: { slidesToShow: 1 } }
                    ]
                });

                // Save original thumbnails once DOM + initial assets are present.
                // Also call again on window.load to be extra safe (covers images loaded later).
                saveOriginalThumbnails();
                $(window).on('load', saveOriginalThumbnails);

                // STOP all videos and restore thumbnail using uid
                function stopAllVideos() {
                    if (!currentPlayingCard) return;
                    const $card = currentPlayingCard;
                    const uid = $card.attr('data-uid');
                    const container = $card.find('.testimonial-media').first();

                    // Stop YouTube
                    const ytKey = 'youtube_' + uid;
                    if (playerInstances[ytKey] && typeof playerInstances[ytKey].stopVideo === 'function') {
                        playerInstances[ytKey].stopVideo();
                    } else {
                        const iframe = container.find('iframe')[0];
                        if (iframe && iframe.src.includes('youtube.com')) {
                            iframe.contentWindow.postMessage(JSON.stringify({ event: "command", func: "stopVideo" }), "*");
                        }
                    }

                    // Stop Vimeo
                    const vimeoKey = 'vimeo_' + uid;
                    if (playerInstances[vimeoKey] && typeof playerInstances[vimeoKey].pause === 'function') {
                        playerInstances[vimeoKey].pause();
                        if (typeof playerInstances[vimeoKey].setCurrentTime === 'function') {
                            playerInstances[vimeoKey].setCurrentTime(0);
                        }
                    } else {
                        const iframe = container.find('iframe')[0];
                        if (iframe && iframe.src.includes('vimeo.com')) {
                            iframe.contentWindow.postMessage(JSON.stringify({ method: 'pause' }), "*");
                        }
                    }

                    // Stop local video
                    const videoEl = container.find('video.testimonial-video')[0];
                    if (videoEl) {
                        try { videoEl.pause(); videoEl.currentTime = 0; } catch (e) { }
                    }

                    // Remove playing/video-loaded classes
                    $card.removeClass('playing video-loaded');

                    // Restore original thumbnail using stored HTML string and clone it into DOM
                    container.empty();
                    if (uid && originalThumbnails[uid]) {
                        // create a jQuery element from HTML string and append a clone
                        container.append($(originalThumbnails[uid]).clone());
                    } else {
                        container.append('<div class="testimonial-thumb testimonial-thumb--placeholder"></div>');
                    }

                    currentPlayingCard = null;
                }

                // PLAY handler uses uid keys for players
                $(document).on('click', '.testimonial-video-card .play-icon', function (e) {
                    e.stopPropagation();
                    const $card = $(this).closest('.testimonial-video-card');
                    const uid = $card.attr('data-uid');
                    const container = $card.find('.testimonial-media').first();
                    const videoType = $card.data('type');
                    let videoUrl = $card.data('src');

                    // Stop previous
                    if (currentPlayingCard && currentPlayingCard[0] !== $card[0]) {
                        stopAllVideos();
                    }

                    // If already loaded, just play
                    if ($card.hasClass('video-loaded')) {
                        // play via stored instances or postMessage
                        const iframe = $card.find('iframe')[0];
                        const videoEl = $card.find('video.testimonial-video')[0];

                        const ytKey = 'youtube_' + uid;
                        if (playerInstances[ytKey] && typeof playerInstances[ytKey].playVideo === 'function') {
                            playerInstances[ytKey].playVideo();
                        } else if (iframe && iframe.src.includes('youtube.com')) {
                            iframe.contentWindow.postMessage(JSON.stringify({ event: "command", func: "playVideo" }), "*");
                        }

                        const vimeoKey = 'vimeo_' + uid;
                        if (playerInstances[vimeoKey] && typeof playerInstances[vimeoKey].play === 'function') {
                            playerInstances[vimeoKey].play();
                        } else if (iframe && iframe.src.includes('vimeo.com')) {
                            iframe.contentWindow.postMessage(JSON.stringify({ method: 'play' }), "*");
                        }

                        if (videoEl) videoEl.play();

                        $card.addClass('playing');
                        currentPlayingCard = $card;
                        return;
                    }

                    // load fresh
                    $card.addClass('video-loaded playing');
                    currentPlayingCard = $card;
                    container.empty();

                    if (videoType === 'Link') {
                        const iframeId = 'video-iframe-' + uid;
                        if (videoUrl.includes('youtube.com/embed/')) {
                            videoUrl += (videoUrl.includes('?') ? '&' : '?') + 'autoplay=1&enablejsapi=1';
                            const iframe = `<div class="video-frame-wrap">
                                    <iframe id="${iframeId}" src="${videoUrl}" frameborder="0" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                                </div>`;
                            container.append(iframe);

                            // init YT player
                            setTimeout(function () {
                                if (window.YT && YT.Player) {
                                    playerInstances['youtube_' + uid] = new YT.Player(iframeId, {
                                        events: {
                                            'onStateChange': function (event) {
                                                if (event.data === YT.PlayerState.PAUSED) $card.removeClass('playing');
                                                else if (event.data === YT.PlayerState.PLAYING) $card.addClass('playing');
                                            }
                                        }
                                    });
                                }
                            }, 800);
                        }

                        if (videoUrl.includes('player.vimeo.com/video/')) {
                            videoUrl += (videoUrl.includes('?') ? '&' : '?') + 'autoplay=1';
                            const iframe = `<div class="video-frame-wrap">
                                    <iframe id="${iframeId}" src="${videoUrl}" frameborder="0" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                                </div>`;
                            container.append(iframe);

                            setTimeout(function () {
                                if (window.Vimeo && Vimeo.Player) {
                                    const player = new Vimeo.Player(iframeId);
                                    playerInstances['vimeo_' + uid] = player;
                                    player.on('pause', function () { $card.removeClass('playing'); });
                                    player.on('play', function () { $card.addClass('playing'); });
                                }
                            }, 800);
                        }
                    }

                    if (videoType === 'File') {
                        const videoTag = `<video class="testimonial-video" autoplay controls><source src="${videoUrl}" type="video/mp4"></video>`;
                        container.append(videoTag);
                        const videoEl = container.find('video.testimonial-video')[0];
                        if (videoEl) {
                            videoEl.addEventListener('pause', function () { $card.removeClass('playing'); });
                            videoEl.addEventListener('play', function () { $card.addClass('playing'); });
                        }
                    }
                });

                // PAUSE handler uses uid mapping as well
                $(document).on('click', '.testimonial-video-card .pause-icon', function (e) {
                    e.stopPropagation();
                    const $card = $(this).closest('.testimonial-video-card');
                    const uid = $card.attr('data-uid');
                    const iframe = $card.find('iframe')[0];
                    const videoEl = $card.find('video.testimonial-video')[0];

                    const ytKey = 'youtube_' + uid;
                    if (playerInstances[ytKey] && typeof playerInstances[ytKey].pauseVideo === 'function') {
                        playerInstances[ytKey].pauseVideo();
                    } else if (iframe && iframe.src.includes('youtube.com')) {
                        iframe.contentWindow.postMessage(JSON.stringify({ event: "command", func: "pauseVideo" }), "*");
                    }

                    const vimeoKey = 'vimeo_' + uid;
                    if (playerInstances[vimeoKey] && typeof playerInstances[vimeoKey].pause === 'function') {
                        playerInstances[vimeoKey].pause();
                    } else if (iframe && iframe.src.includes('vimeo.com')) {
                        iframe.contentWindow.postMessage(JSON.stringify({ method: 'pause' }), "*");
                    }

                    if (videoEl) videoEl.pause();
                    $card.removeClass('playing');
                });

                // Stop video when slider changes
                $('.testimonial-video-slider').on('beforeChange', function () {
                    stopAllVideos();
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