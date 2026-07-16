jQuery(document).ready(function($) {
	$(function () {
	  AOS.init({
		once: true,
		duration: 500,
		offset: 120,
		easing: 'ease-out-cubic',
		mirror: false,
		disableMutationObserver: true,
		disable: function () {
		  return window.innerWidth < 767;
		}
	  });
		
		document.body.classList.add("aos-initialized");
        setTimeout(function(){
            AOS.refresh();
        }, 500);
	});
	
    // Fixed Header
    jQuery(window).scroll(function() {
        var scroll = jQuery(window).scrollTop();
        if (scroll >= 45) {
            jQuery('.site-header').addClass("fixed-header");
        } else {
            jQuery('.site-header').removeClass("fixed-header");
        }
    });

    // Fixed Footer
    jQuery('.footer-menu').on('click', 'h5', function(){
        jQuery(this).parent().toggleClass('active');
    });

    // Hero Banner trustedBy
    if (jQuery('.heroBanner__trustedBy-slider').length) {
        jQuery('.heroBanner__trustedBy-slider').slick({
            infinite: true,
            dots: false,
            arrows: false,
            autoStart: true,
            autoplay: true,
            autoplaySpeed: 0,
            speed: 5000,
            slidesToShow:5,
            slidesToScroll:1,
            cssEase: 'linear',
            draggable: false,
            pauseOnHover: false,
            pauseOnFocus: false,
			adaptiveHeight: false,
            responsive: [
                {
                breakpoint: 1280,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
                },
                {
                breakpoint: 767,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
                },
                {
                breakpoint: 576,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
                }
            ]
        });
    }

    jQuery('.heroBanner__about-slider').slick({
        infinite: true,
        dots: false,
        arrows: false,
        autoStart: true,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 5000,
        slidesToShow:4,
        slidesToScroll:1,
        cssEase: 'linear',
        draggable: false,
        pauseOnHover: false,
        pauseOnFocus: false,
		adaptiveHeight: false,
        responsive: [
            {
              breakpoint: 767,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 576,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 420,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1
              }
            }
        ]
    });

    // Equalize visible slide heights
    function equalizeVisibleHeights(slider) {
      const $slides = slider.find('.slick-slide');
      let maxHeight = 0;

      $slides.css('height', 'auto');

      slider.find('.slick-slide.slick-active').each(function () {
        const h = jQuery(this).outerHeight();
        if (h > maxHeight) maxHeight = h;
      });

      slider.find('.slick-slide.slick-active').css('height', maxHeight + 'px');
    }

    // Apply on reposition
    jQuery('.our-blogs-content').on('setPosition', function () {
      equalizeVisibleHeights(jQuery(this));
    });

    
    jQuery('.packages-slider').on('setPosition', function () {
      equalizeVisibleHeights(jQuery(this));
    });

});

jQuery(document).ready(function ($) {
    jQuery('.testimonials-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        centerMode: true,
        centerPadding: '0px',
        infinite: true,
        focusOnSelect: true,
        dots: false,
        arrows: false,
        speed: 500,
        cssEase: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)',
        responsive: [
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    centerMode: true,
                    centerPadding: '0px',
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    centerMode: false,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerMode: false,
                }
            }
        ]
    });

    jQuery('.testimonials-prev-btn').on('click', function () {
        jQuery('.testimonials-slider').slick('slickPrev');
    });
    jQuery('.testimonials-next-btn').on('click', function () {
        jQuery('.testimonials-slider').slick('slickNext');
    });

});


jQuery(document).ready(function ($) {

    var $slider  = $('.packages-slider');

    if (!$slider.length) return;

    var autoTimer = null;
    var delay     = 2500; // time between moves

    function toggleDots(slick) {
        var slidesToShow = slick.options.slidesToShow;
        var slideCount   = slick.slideCount;
        var $dots        = $(slick.$dots);

        if (!$dots.length) return;

        // If no scrolling possible → hide dots
        if (slideCount <= slidesToShow) {
            $dots.hide();
        } else {
            $dots.show();
        }
    }


    function startAuto(slick) {
        stopAuto();

        if (!slick || slick.slideCount <= slick.options.slidesToShow) return;

        autoTimer = setInterval(function () {
            var lastIndex = slick.slideCount - slick.options.slidesToShow;

            if (slick.currentSlide >= lastIndex) {
                // jump back to first (no animation glitch)
                $slider.slick('slickGoTo', 0);
            } else {
                $slider.slick('slickNext');
            }
        }, delay);
    }

    function stopAuto() {
        if (autoTimer) {
            clearInterval(autoTimer);
            autoTimer = null;
        }
    }

    /* --------------------------------
     * Slick lifecycle
     * -------------------------------- */
    $slider
        .on('init', function (event, slick) {
            toggleDots(slick);
            startAuto(slick);
        })
        .on('afterChange', function (event, slick) {
            // keep slick reference fresh
            toggleDots(slick);
            startAuto(slick);
        })
        .on('breakpoint', function (event, slick) {
            toggleDots(slick);
        })
        .on('mouseenter', function () {
            stopAuto();
        })
        .on('mouseleave', function () {
            var slick = $slider.slick('getSlick');
            startAuto(slick);
        });

    /* --------------------------------
     * Init Slick ONCE
     * -------------------------------- */
    $slider.slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        dots: true,
        infinite: false,
        autoplay: false,
//         speed: 500,
//         cssEase: 'ease',
        pauseOnHover: false,
        pauseOnFocus: false,
        draggable: true,
        swipe: true,
        touchMove: true,
        swipeToSlide: false,
		touchThreshold: 4,
        speed: 250,
        cssEase: 'cubic-bezier(0.4, 0, 0.2, 1)',
        waitForAnimate: false,
        edgeFriction: 0.15,
        accessibility: false,
        adaptiveHeight: false,
        responsive: [
            { breakpoint: 1360, settings: { slidesToShow: 3 } },
            { breakpoint: 1199, settings: { slidesToShow: 3 } },
            { breakpoint: 991,  settings: { slidesToShow: 2 } },
            { breakpoint: 576,  settings: { slidesToShow: 1 } }
        ]
    });

});

window.addEventListener('load', function () {
  document.querySelectorAll('.gif-swap').forEach(img => {
    img.src = img.dataset.gif;
  });
});

window.addEventListener('load', function () {
    document.body.classList.add('page-loaded');
});