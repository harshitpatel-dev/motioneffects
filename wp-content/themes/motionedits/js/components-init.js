/**
 * Consolidated inline <script> blocks that used to live scattered across
 * components/sections/*.php (Phase 3 performance cleanup). Each block below
 * is self-contained (its own jQuery(document).ready/IIFE) and no-ops safely
 * if its section isn't present on the current page, so concatenating them
 * here is safe regardless of which sections a given page actually uses.
 *
 * Not included here (left inline, since they interpolate per-instance PHP
 * values that a shared static file can't see): grid_column.php,
 * feature_videos.php, our_blogs.php.
 */

/* ---- from accordian.php (was lines 193-222) ---- */
jQuery(document).ready(function () {

    jQuery(".filter-button-group li button").on("click", function () {

        let category = jQuery(this).data("category"); // slug

        // Hide all
        jQuery(".faq-block").hide();

        // Show selected
        jQuery(".faq-" + category).show();

        // Open first item in selected category ONLY
        jQuery(".faq-" + category)
            .find(".accordion-collapse")
            .removeClass("show")
            .first()
            .addClass("show");
    });

    // Default active category
    let firstCat = jQuery(".filter-button-group li button.active").data("category");

    if (firstCat) {
        jQuery(".faq-block").hide();
        jQuery(".faq-" + firstCat).show();
    }
});

/* ---- from culture_slider.php (was lines 69-117) ---- */
    const scrollers = document.querySelectorAll(".scroller");

    // If a user hasn't opted in for recuded motion, then we add the animation
    if (!window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    addAnimation();
    }

    function addAnimation() {
        scrollers.forEach((scroller) => {
            // add data-animated="true" to every `.scroller` on the page
            scroller.setAttribute("data-animated", true);

            const scrollerInner = scroller.querySelector(".scroller__inner");
            const scrollerContent = Array.from(scrollerInner.children);

            scrollerContent.forEach((item) => {
            const duplicatedItem = item.cloneNode(true);
            duplicatedItem.setAttribute("aria-hidden", true);
            scrollerInner.appendChild(duplicatedItem);
            });
        });
    }


    document.addEventListener("DOMContentLoaded", function () {
        const lazyImages = document.querySelectorAll("img.lazy-img");

        lazyImages.forEach(img => {
            if (img.complete) {
            handleImageLoad(img);
            } else {
            img.addEventListener("load", function () {
                handleImageLoad(img);
            });
            }

        });

        function handleImageLoad(img) {
            img.classList.add("loaded");
            const skeleton = img.parentElement.querySelector(".skeleton");
            if (skeleton) {
            skeleton.remove();
            }
        }
    });


/* ---- from one_or_more_columns.php (was lines 683-730) ---- */
    (function () {
        /* Click the custom play button -> start the real player WITH sound.
           Because this runs from a real click, browsers allow unmuted playback. */
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.video-play-btn');
            if (!btn) return;

            var wrap = btn.closest('.video-player');
            if (!wrap) return;

            if (wrap.dataset.player === 'file') {
                var video = wrap.querySelector('video');
                if (!video) return;
                video.muted = false;
                video.volume = 1;
                video.setAttribute('controls', 'controls'); // hand over to native controls
                video.play();
            } else {
                if (wrap.classList.contains('is-loaded')) return;
                var src = wrap.dataset.src;
                if (!src) return;

                var iframe = document.createElement('iframe');
                iframe.src = src;
                iframe.title = 'Video player';
                iframe.setAttribute('frameborder', '0');
                iframe.setAttribute('allow', 'autoplay; encrypted-media; fullscreen; picture-in-picture');
                iframe.setAttribute('allowfullscreen', '');
                wrap.appendChild(iframe);
                wrap.classList.add('is-loaded');
            }

            wrap.classList.add('is-playing');
        });

        /* For uploaded files, bring the play button back when paused/ended.
           play/pause don't bubble, so listen in the capture phase. */
        ['play', 'pause', 'ended'].forEach(function (evt) {
            document.addEventListener(evt, function (e) {
                if (!e.target || e.target.tagName !== 'VIDEO') return;
                var wrap = e.target.closest('.video-player');
                if (!wrap) return;
                wrap.classList.toggle('is-playing', evt === 'play');
            }, true);
        });
    })();

/* ---- from one_or_more_columns.php (was lines 621-675) ---- */
jQuery(document).ready(function($){
 /* Inner Column Grid Slider */
    jQuery('.inner-column-slider').slick({
		infinite: false,
        slidesToShow: 4,
        slidesToScroll: 1,
        dots: false,
        arrows: false,
        autoplay: true,
		 swipe: true,
    draggable: true,
    touchMove: true,
    swipeToSlide: false,
					
					touchThreshold: 4,   // LOWER = faster swipe
    speed: 250,          // FAST animation
    cssEase: 'cubic-bezier(0.4, 0, 0.2, 1)', // Google Material easing

    /* Prevent sluggish feel */
    waitForAnimate: false,
    edgeFriction: 0.15,

    /* Stability */
    accessibility: false,
		adaptiveHeight: false,
        responsive: [
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
					dots: true,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
					dots: true,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
					dots: true,
                }
            }
        ]
    });
	});

/* ---- from one_or_more_columns.php (was lines 556-618) ---- */
        jQuery(document).ready(function ($) {

            function initToolsMobileSlider() {
                var slider = $('.mobile-column-slider');

                if (window.innerWidth <= 991) {
                    if (!slider.hasClass('slick-initialized')) {
                        slider.slick({
					infinite: false,
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            dots: false,
                            arrows: false,
                            autoplay: true,
							 swipe: true,
    draggable: true,
    touchMove: true,
    swipeToSlide: false,
					
					touchThreshold: 4,   // LOWER = faster swipe
    speed: 250,          // FAST animation
    cssEase: 'cubic-bezier(0.4, 0, 0.2, 1)', // Google Material easing

    /* Prevent sluggish feel */
    waitForAnimate: false,
    edgeFriction: 0.15,

    /* Stability */
    accessibility: false,
							adaptiveHeight: false,
                            responsive: [
                                {
                                    breakpoint: 767,
                                    settings: {
                                        slidesToShow: 2,
                                        slidesToScroll: 1,
										dots: true,
                                    }
                                },
                                {
                                    breakpoint: 576,
                                    settings: {
                                        slidesToShow: 1,
                                        slidesToScroll: 1,
										dots: true,
                                    }
                                }
                            ]
                        });
                    }
                } else {
                    if (slider.hasClass('slick-initialized')) {
                        slider.slick('unslick');
                    }
                }
            }

            initToolsMobileSlider();
            $(window).on('resize', initToolsMobileSlider);

        });

/* ---- from one_or_more_columns.php (was lines 335-371) ---- */
                                                            document.addEventListener('DOMContentLoaded', function () {

                                                        document.addEventListener('wpcf7mailsent', function () {

                                                            if (event.detail.status !== 'mail_sent') return;

                                                            const contactSection = document.getElementsByClassName('contact-section')[0];
                                                            const thankyouSection = document.getElementsByClassName('thankyou-section')[0];

                                                            if (contactSection && thankyouSection) {
                                                                thankyouSection.style.display = 'block';
                                                                contactSection.style.display = 'none';
                                                            }

                                                            setTimeout(function () {
                                                                const responseOutput = document.querySelector('.wpcf7-response-output');
                                                                if (responseOutput && responseOutput.innerText.includes('Thank you for your message')) {
                                                                    responseOutput.textContent = '';
                                                                }

                                                                const form = document.querySelector('.wpcf7 form');
                                                                if (form && form.classList.contains('sent')) {
                                                                    form.classList.remove('sent');
                                                                    form.classList.add('init');
                                                                }
                                                            }, 1500);
															
															 // REDIRECT TO THANK YOU PAGE
															setTimeout(function () {
																window.location.href = "/thank-you/";
															}, 2000); // delay for smooth UX

                                                        }, false);

                                                    });

/* ---- from our_services.php (was lines 120-191) ---- */
jQuery(document).ready(function ($) {

    var $slider = $('.custom-grid-slider');

    function initToolsMobileSlider() {

        if (window.innerWidth <= 767) {

            $slider.removeClass('custom-grid');

            if (!$slider.hasClass('slick-initialized')) {

                $slider.slick({
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    dots: true,
                    arrows: true,
                    infinite: false,
                    speed: 800,
                    adaptiveHeight: false,
                    responsive: [
                        {
                            breakpoint: 576,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                            }
                        }
                    ]
                });

                // Equalize after init and on resize/swipe
                $slider.on('setPosition equalize', function () {
                    equalizeCardHeights($(this));
                });

                // Initial run
                equalizeCardHeights($slider);
            }

        } else {

            if ($slider.hasClass('slick-initialized')) {
                $slider.slick('unslick');
                resetCardHeights();
            }
        }
    }

    function equalizeCardHeights(slider) {
        let maxHeight = 0;
        const $cards = slider.find('.slick-slide.slick-active .card');

        $cards.css('height', 'auto');

        $cards.each(function () {
            maxHeight = Math.max(maxHeight, $(this).outerHeight());
        });

        $cards.css('height', maxHeight + 'px');
    }

    function resetCardHeights() {
        $('.custom-grid-slider .card').css('height', 'auto');
    }

    initToolsMobileSlider();
    $(window).on('resize orientationchange', initToolsMobileSlider);

});

/* ---- from posters.php (was lines 60-107) ---- */
    jQuery(document).ready(function() {

        jQuery('.poster-slider').slick({
            infinite: true,
            dots: true,
            arrows: true,
            autoStart: true,
            autoplay: true,
            autoplaySpeed: 2000,
            speed: 1000,
            slidesToShow: 4,
            slidesToScroll: 1,
            cssEase: 'linear',
            draggable: true,
            pauseOnHover: false,
            pauseOnFocus: false,
            adaptiveHeight: false,
            responsive: [{
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        dots: true,
                        arrows: true,
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        dots: true,
                        arrows: true,
                    }
                }
            ]
        });

    });

/* ---- from our_portfolios.php (was lines 556-716) ---- */
    jQuery(function($) {

        /* -----------------------------
         Stagger animation
        ----------------------------- */
        function animatePortfolioItems($container) {
            $container.find('.grid-item:visible').each(function(i) {
                this.classList.remove('stagger-animate');
                this.style.animationDelay = '0ms';

                void this.offsetWidth;

                this.style.animationDelay = (i * 100) + 'ms';
                this.classList.add('stagger-animate');
            });
        }

        /* -----------------------------
         Equal height
        ----------------------------- */
        function equalizePortfolioHeights() {
            const $items = $('.our-portfolio:visible');
            if (!$items.length) return;

            let currentTop = null;
            let maxHeight = 0;
            let rowItems = [];

            $items.find('.content-wrap').css('height', 'auto');

            $items.each(function() {
                const $item = $(this);
                const top = Math.round($item.position().top);
                const $content = $item.find('.content-wrap');
                const height = $content.outerHeight();

                if (currentTop !== null && top !== currentTop) {
                    rowItems.forEach(el => el.find('.content-wrap').height(maxHeight));
                    rowItems = [];
                    maxHeight = 0;
                }

                maxHeight = Math.max(maxHeight, height);
                rowItems.push($item);
                currentTop = top;
            });

            rowItems.forEach(el => el.find('.content-wrap').height(maxHeight));
        }

        /* -----------------------------
         LOAD MORE PER GROUP
        ----------------------------- */
        function initPortfolioLoadMore() {

            $('.portfolio-group').each(function() {

                const $group = $(this);
                const $block = $group.closest('.portfolio-block');
                const $items = $group.find('.our-portfolio');
                const $btn = $block.find('.load-more-btn');

                if (!$items.length || !$btn.length) return;

                const isReel = $items.first().hasClass('reels-videos');
                const visibleCount = isReel ? 8 : 6;

                // RESET
                $items.hide().slice(0, visibleCount).show();

                // BUTTON
                if ($items.length > visibleCount) {
                    $btn.show();
                } else {
                    $btn.hide();
                }

                $btn.off('click').on('click', function() {

                    const visible = $items.filter(':visible').length;
                    const next = $items.slice(visible, visible + visibleCount);

                    next.each(function(i) {
                        this.classList.remove('stagger-animate');
                        this.style.animationDelay = '0ms';

                        void this.offsetWidth;

                        this.style.animationDelay = (i * 100) + 'ms';

                        $(this).fadeIn(200, function() {
                            this.classList.add('stagger-animate');
                        });
                    });

                    if ($items.filter(':visible').length >= $items.length) {
                        $btn.hide();
                    }

                    equalizePortfolioHeights();
                });

            });
        }

        /* -----------------------------
         TAB CHANGE
        ----------------------------- */
        $('#portfolioTabs button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            const $pane = $($(e.target).data('bs-target'));

            initPortfolioLoadMore();
            animatePortfolioItems($pane);

            if (typeof AOS !== "undefined") {
                AOS.refreshHard();
            }
        });

        /* -----------------------------
         PAGE LOAD
        ----------------------------- */
        $(window).on('load', function() {
            initPortfolioLoadMore();
            animatePortfolioItems($('.tab-pane.show.active'));

            if (typeof AOS !== "undefined") {
                AOS.refreshHard();
            }
        });

        $(window).on('resize', equalizePortfolioHeights);

        /* -----------------------------
         VIDEO MODAL
        ----------------------------- */
        const $modal = $('#portfolioVideoModal');
        const $iframe = $('#portfolio-video-frame');

        $('#portfolio').on('click', '.thumbnails-icon', function() {
            let url = $(this).data('video');
            if (!url) return;

            if (url.includes('youtube')) {
                url = url.replace('watch?v=', 'embed/') + '?autoplay=1';
            } else if (url.includes('vimeo')) {
                url = url.includes('player.vimeo.com') ?
                    url + '?autoplay=1' :
                    url.replace('vimeo.com', 'player.vimeo.com/video') + '?autoplay=1';
            }

            $iframe.attr('src', url);
        });

        $modal.on('hidden.bs.modal', function() {
            $iframe.attr('src', '');
        });

    });

/* ---- from testimonial.php (was lines 150-509) ---- */
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

                // Load YouTube / Vimeo player APIs lazily and only once page-wide,
                // even if this testimonials section is repeated multiple times.
                // Previously these loaded unconditionally on document ready per
                // section instance, causing the player script to be fetched
                // several times before any video was ever played.
                function motionedits_loadYouTubeAPI() {
                    if (window.__meYouTubeApiLoading) return;
                    window.__meYouTubeApiLoading = true;

                    if (window.YT && window.YT.Player) {
                        youtubeAPIReady = true;
                        return;
                    }

                    const tag = document.createElement('script');
                    tag.src = 'https://www.youtube.com/iframe_api';
                    const firstScriptTag = document.getElementsByTagName('script')[0];
                    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                }
                window.onYouTubeIframeAPIReady = function () { youtubeAPIReady = true; };

                function motionedits_loadVimeoAPI() {
                    if (window.__meVimeoApiLoading) return;
                    window.__meVimeoApiLoading = true;

                    if (window.Vimeo) {
                        vimeoAPIReady = true;
                        return;
                    }

                    const vimeoScript = document.createElement('script');
                    vimeoScript.src = 'https://player.vimeo.com/api/player.js';
                    vimeoScript.onload = function () { vimeoAPIReady = true; };
                    document.head.appendChild(vimeoScript);
                }

                // Kick off loading once the slider is actually near the viewport,
                // instead of on every page load regardless of scroll position.
                const $testimonialSlider = $('.testimonial-video-slider').first();
                if ($testimonialSlider.length && 'IntersectionObserver' in window) {
                    const apiObserver = new IntersectionObserver(function (entries) {
                        entries.forEach(function (entry) {
                            if (entry.isIntersecting) {
                                motionedits_loadYouTubeAPI();
                                motionedits_loadVimeoAPI();
                                apiObserver.disconnect();
                            }
                        });
                    }, { rootMargin: '300px 0px' });
                    apiObserver.observe($testimonialSlider[0]);
                } else {
                    // Fallback for browsers without IntersectionObserver support
                    motionedits_loadYouTubeAPI();
                    motionedits_loadVimeoAPI();
                }

                // Safety net: make sure the relevant API is loading by the time a
                // user actually clicks play, even if they clicked before the
                // slider intersection fired (e.g. fast scroll + immediate click).
                $(document).on('click', '.testimonial-video-card .play-icon', function () {
                    const videoType = $(this).closest('.testimonial-video-card').data('type');
                    const videoUrl = $(this).closest('.testimonial-video-card').data('src') || '';
                    if (videoType === 'Link' && videoUrl.includes('youtube.com')) {
                        motionedits_loadYouTubeAPI();
                    } else if (videoType === 'Link' && videoUrl.includes('vimeo.com')) {
                        motionedits_loadVimeoAPI();
                    }
                });

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
//                     draggable: false,
					/* 🔥 Drag & swipe tuning */
    swipe: true,
    draggable: true,
    touchMove: true,
    swipeToSlide: false,
					
					touchThreshold: 4,   // LOWER = faster swipe
    speed: 250,          // FAST animation
    cssEase: 'cubic-bezier(0.4, 0, 0.2, 1)', // Google Material easing

    /* Prevent sluggish feel */
    waitForAnimate: false,
    edgeFriction: 0.15,

    /* Stability */
    accessibility: false,
					adaptiveHeight: false,
                    responsive: [
                        { breakpoint: 1199, settings: { slidesToShow: 4 } },
                        { breakpoint: 991, settings: { slidesToShow: 3 } },
						{ breakpoint: 767, settings: { slidesToShow: 2.5,slidesToScroll: 1 } },
                        { breakpoint: 576, settings: { slidesToShow: 2.1,slidesToScroll: 1 } },
                        { breakpoint: 420, settings: { slidesToShow: 1.5,slidesToScroll: 1 } }
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

