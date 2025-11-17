jQuery(document).ready(function($) {

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

    // Hero Banner
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
        draggable: true,
        responsive: [
            {
              breakpoint: 1440,
              settings: {
                slidesToShow: 5,
                slidesToScroll: 1
              }
            },
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
                slidesToShow: 2,
                slidesToScroll: 1
              }
            }
        ]
    });

    /* Our Blogs */
    jQuery('.our-blogs-content').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: false,
        arrows: false,
        autoplay: false,
        responsive: [
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 2,
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

    /* Inner Column Grid Slider */
    jQuery('.inner-column-slider').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        dots: false,
        arrows: false,
        autoplay: true,
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

});
