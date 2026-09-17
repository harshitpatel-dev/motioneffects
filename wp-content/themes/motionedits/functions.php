<?php
/**
 * motionedits functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package motionedits
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * vfx.motionedits.com and video-editor.motionedits.com don't need spam
 * protection on their contact forms, but the contact-form-7-simple-recaptcha
 * plugin loads unconditionally on every domain sharing this WordPress
 * install (its includes/recaptcha.php and includes/recaptcha-v3.php are
 * require_once'd directly, not gated behind any hook) - costing ~1MB of JS
 * and a large chunk of Total Blocking Time even on pages where the client
 * never asked for a captcha. Both the widget/token shortcodes and the
 * server-side validation filter are removed here for those two subdomains,
 * so submissions aren't rejected for missing a token that never gets
 * generated. motionedits.com is untouched and keeps captcha protection.
 */
function motionedits_is_captcha_free_subdomain() {
	$host = strtolower( $_SERVER['HTTP_HOST'] ?? '' );
	return in_array( $host, array( 'video-editor.motionedits.com', 'vfx.motionedits.com' ), true );
}

function motionedits_disable_recaptcha_on_subdomains() {
	if ( ! motionedits_is_captcha_free_subdomain() ) {
		return;
	}

	// v3 (invisible, score-based)
	remove_shortcode( 'cf7sr-v3-recaptcha' );
	add_shortcode( 'cf7sr-v3-recaptcha', '__return_empty_string' );
	remove_filter( 'wpcf7_validate', 'cf7sr_verify_recaptcha_v3', 20 );

	// v2 (checkbox/image challenge)
	remove_shortcode( 'cf7sr-simple-recaptcha' );
	remove_shortcode( 'cf7sr-recaptcha' );
	add_shortcode( 'cf7sr-simple-recaptcha', '__return_empty_string' );
	add_shortcode( 'cf7sr-recaptcha', '__return_empty_string' );
	remove_filter( 'wpcf7_validate', 'cf7sr_verify_recaptcha', 20 );
}
add_action( 'init', 'motionedits_disable_recaptcha_on_subdomains', 20 );

/**
 * jquery-migrate is enqueued by WordPress core automatically alongside
 * jQuery, as a compatibility shim for deprecated jQuery APIs (.live(),
 * .size(), etc.). Neither this theme's own JS (custom.js, navigation.js,
 * aos.js, every component's inline script) nor jQuery core itself needs it
 * on video-editor/vfx - it's dead weight there. Left in place on
 * motionedits.com in case any other plugin's frontend JS on that domain
 * relies on it.
 */
function motionedits_remove_jquery_migrate_on_subdomains( $scripts ) {
	if ( is_admin() || ! motionedits_is_captcha_free_subdomain() ) {
		return;
	}

	if ( isset( $scripts->registered['jquery'] ) ) {
		$scripts->registered['jquery']->deps = array_diff(
			$scripts->registered['jquery']->deps,
			array( 'jquery-migrate' )
		);
	}
}
add_action( 'wp_default_scripts', 'motionedits_remove_jquery_migrate_on_subdomains' );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function motionedits_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on motionedits, use a find and replace
		* to change 'motionedits' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'motionedits', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'motionedits' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'motionedits_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'motionedits_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function motionedits_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'motionedits_content_width', 640 );
}
add_action( 'after_setup_theme', 'motionedits_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function motionedits_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'motionedits' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'motionedits' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'motionedits_widgets_init' );

/**
 * Enqueue styles and scripts for the MotionEdits theme.
 */
function motionedits_scripts() {
    $theme_version = wp_get_theme()->get('Version');

    // Bootstrap
    wp_enqueue_style(
        'motionedits-bootstrap',
        get_template_directory_uri() . '/css/bootstrap.min.css',
        [],
        '5.3.8'
    );

    // Boxicons
    wp_enqueue_style(
        'motionedits-boxicons',
        get_template_directory_uri() . '/css/boxicons.min.css',
        [],
        '2.1.4'
    );

    // Slick Slider
    wp_enqueue_style(
        'motionedits-slick',
        get_template_directory_uri() . '/css/slick.css',
        [],
        '1.8.1'
    );
	
	wp_style_add_data( 'slick-css', 'preload', true );

    wp_enqueue_style(
        'motionedits-slick-theme',
        get_template_directory_uri() . '/css/slick-theme.css',
        ['motionedits-slick'],
        '1.8.1'
    );

	wp_enqueue_style( 'motionedits-variables', get_template_directory_uri().'/css/variables.css', array(), _S_VERSION );
	wp_enqueue_style( 'motionedits-aos', get_template_directory_uri().'/css/aos.css', array(), _S_VERSION );

    // Main style.css
    wp_enqueue_style(
        'motionedits-style',
        get_stylesheet_uri(),
        ['motionedits-bootstrap', 'motionedits-variables'],
        $theme_version
    );
    wp_style_add_data('motionedits-style', 'rtl', 'replace');
    
    
   // print get_template_directory_uri() . '/js/bootstrap.bundle.min.js'; exit;

    // Bootstrap Bundle (includes Popper)
    wp_enqueue_script(
        'motionedits-bootstrap',
        get_template_directory_uri() . '/js/bootstrap.bundle.min.js',
        array('jquery'),
        '5.3.8',
        true
    );

    

    // Custom navigation or main script
    wp_enqueue_script(
        'motionedits-navigation',
        get_template_directory_uri() . '/js/navigation.js',
        array('jquery'),
        $theme_version,
        true
    );


    wp_enqueue_script(
        'motionedits-aos-js',
        get_template_directory_uri() . '/js/aos.js',
        array('jquery'),
        $theme_version,
        true
    );
    
    // Slick Slider JS
    wp_enqueue_script(
        'motionedits-slick',
        get_template_directory_uri() . '/js/slick.min.js',
        array('jquery'),
        '1.8.1',
        true
    );

    wp_enqueue_script(
        'motionedits-custom-js',
        get_template_directory_uri() . '/js/custom.js',
        array('jquery'),
        $theme_version,
        true
    );
    
    

    // Comment reply for threaded comments
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'motionedits_scripts');

/**
 * MaxMegaMenu unconditionally enqueues the full WordPress admin dashicons
 * stylesheet (~35KB) on the frontend whenever its arrow/close icon setting
 * is left on "Dashicons" (Mega_Menu_Dashicons::enqueue_styles(), hooked to
 * megamenu_enqueue_public_scripts). PageSpeed confirms 100% of it is unused
 * here, and no dashicons-* class actually appears in the rendered menu
 * markup, so it's safe to drop outright. Priority 100 ensures this runs
 * after the megamenu plugin (and anything else) has already enqueued it.
 */
function motionedits_dequeue_unused_dashicons() {
	if (is_admin()) {
		return;
	}
	wp_dequeue_style('dashicons');
	wp_deregister_style('dashicons');
}
add_action('wp_enqueue_scripts', 'motionedits_dequeue_unused_dashicons', 100);

/**
 * WordPress core doesn't read intrinsic dimensions for SVG uploads (no
 * SVG-metadata plugin is installed here), so ACF image fields report
 * width=0/height=0 for every SVG icon - even though the SVG files
 * themselves declare real width/height in their root <svg> tag. That gap
 * is why icon grids using SVGs (tool/software logos, feature icons) were
 * still failing "explicit width and height" CLS audits even after PNG/GIF
 * icons got fixed. This reads the dimensions directly from the file as a
 * fallback, falling back again to the viewBox if the root tag has no
 * explicit width/height. Result is cached per-request since the same icon
 * URL is often reused across several grid items.
 */
function motionedits_get_svg_dimensions($svg_url) {
	static $cache = array();

	if (isset($cache[$svg_url])) {
		return $cache[$svg_url];
	}

	$upload_dir = wp_get_upload_dir();
	$path       = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $svg_url);

	if (!file_exists($path)) {
		return $cache[$svg_url] = array(0, 0);
	}

	// Only the opening <svg> tag is needed, which is always near the start
	// of the file - read a small chunk regardless of the file's total size
	// (some of these "SVGs" are actually several hundred KB because they
	// embed raster image data, but that doesn't cost us anything here).
	$contents = file_get_contents($path, false, null, 0, 4096);
	$root     = null;
	if (preg_match('/<svg\b[^>]*>/i', $contents, $m)) {
		$root = $m[0];
	}

	$width = $height = 0;
	if ($root) {
		if (preg_match('/\bwidth="([\d.]+)/i', $root, $w) && preg_match('/\bheight="([\d.]+)/i', $root, $h)) {
			$width  = (float) $w[1];
			$height = (float) $h[1];
		} elseif (preg_match('/\bviewBox="[\d.\s-]+"/i', $root, $vb)) {
			$parts = preg_split('/[\s,]+/', trim(str_replace(array('viewBox="', '"'), '', $vb[0])));
			if (count($parts) === 4) {
				$width  = (float) $parts[2];
				$height = (float) $parts[3];
			}
		}
	}

	return $cache[$svg_url] = array($width, $height);
}

/**
 * Boxicons used to be deferred here via the media="print" onload="..." trick
 * to keep it off the render-blocking chain. On the live site NitroPack also
 * runs its own CSS deferral/critical-CSS pass over every stylesheet, and the
 * two deferral layers collided: NitroPack's rewrite of our onload link only
 * left the <noscript> fallback in the rendered HTML, so JS-enabled visitors
 * (i.e. everyone) never got the real stylesheet and footer/header social
 * icons (bx bxl-*) silently failed to render. NitroPack already defers this
 * stylesheet on its own, so the manual trick is redundant - removed.
 */


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


/**
 * Disable ACF Pro update notifications and auto-updates.
 */
function disable_acf_pro_update( $value ) {
    if ( isset( $value ) && is_object( $value ) ) {
        unset( $value->response['advanced-custom-fields-pro/acf.php'] );
    }
    return $value;
}
add_filter( 'site_transient_update_plugins', 'disable_acf_pro_update' );

/**
 * Theme Setting
 */
function my_acf_op_init() {
	if( function_exists('acf_add_options_page') ) {
		$parent = acf_add_options_page(array(
			'page_title'  => __('Theme General Settings'),
            'menu_title'  => __('Theme Settings'),
            'redirect'    => false,
			'capability'  => 'manage_options',
        ));
		
    }
}
add_action('acf/init', 'my_acf_op_init');

/**
 * Svg Image Uploads Funtion 
 */
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/**
 * One-time cleanup: the old 'monthly' cron schedule used a fixed
 * MONTH_IN_SECONDS (30-day) interval, which drifts against real calendar
 * months (28-31 days) and eventually fires before the month actually ends.
 * That caused reports to be sent for the wrong month. Both report crons
 * now self-reschedule for the literal "first day of next month" instead,
 * so this clears out any previously (mis-)scheduled recurring event.
 */
if (!get_option('motionedits_monthly_cron_fix_v1')) {
    wp_clear_scheduled_hook('cfdb7_monthly_csv_event');
    wp_clear_scheduled_hook('calendly_monthly_report');
    update_option('motionedits_monthly_cron_fix_v1', 1);
}

/**
 * MAIN FUNCTION TO EXPORT AND SEND CSV
 */
function cfdb7_send_csv()
{
    global $wpdb;

	error_log('Cron Triggered Successfully at: ' . current_time('mysql'));
    $admin_email = get_option('admin_email');
    $table = $wpdb->prefix . 'db7_forms';

    // DATE RANGE: previous month
    $from = date('Y-m-01', strtotime('first day of last month'));
    $to   = date('Y-m-t', strtotime('last day of last month'));



    // FETCH SUBMISSIONS
    $results = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table WHERE form_date BETWEEN %s AND %s ORDER BY form_date ASC",
            $from,
            $to
        ),
        ARRAY_A
    );

    if (empty($results)) {
        error_log(" CFDB7: No records found for $from to $to");
        return;
    }

    // CREATE CSV FILE
    $upload_dir = wp_upload_dir();
    $file_path = $upload_dir['basedir'] . "/cfdb7_submissions_{$from}_to_{$to}.csv";

    $fp = fopen($file_path, 'w');

    // CSV HEADER
    $header = [
        'Submission Date',
        'Name',
        'Email',
        'Phone Number',
        'Country',
        'Message',
        'Math Captcha'
    ];
    fputcsv($fp, $header);

    // FILL CSV ROWS
    foreach ($results as $row) {
        $data = maybe_unserialize($row['form_value']);
		
		$country = '';

        if (!empty($data['country'])) {
            $country = is_array($data['country'])
                ? implode(', ', $data['country'])
                : $data['country'];
        } elseif (!empty($data['Country'])) {
            $country = is_array($data['Country'])
                ? implode(', ', $data['Country'])
                : $data['Country'];
        }

        fputcsv($fp, [
            $row['form_date'],
            $data['your-name'] ?? '',
            $data['your-email'] ?? '',
            $data['your-number'] ?? '',
            //$data['country'] ?? '',
            $country,
            $data['your-message'] ?? '',
            $data['math-captcha'] ?? ''
        ]);
    }

    fclose($fp);

    // EMAIL CONTENT
    $subject = "Monthly Sales Report ({$from} to {$to})";

    $body .= "<p>Dear Admin,</p>";
    $body .= "<p>Please find attached the CSV export of CFDB7 form submissions for the period <strong>{$from}</strong> to <strong>{$to}</strong>.</p>";

    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: <' . $admin_email . '>',
    ];

    // SEND EMAIL
    $sent = wp_mail(
        $admin_email,
        $subject,
        $body,
        $headers,
        [$file_path]
    );

    if ($sent) {
        error_log("CFDB7 CSV sent successfully to {$admin_email}");
    } else {
        error_log("CFDB7 CSV failed to send to {$admin_email}");
    }

    // Reschedule for the first day of the next calendar month.
    wp_schedule_single_event(strtotime('first day of next month 00:00'), 'cfdb7_monthly_csv_event');
}

if (!wp_next_scheduled('cfdb7_monthly_csv_event')) {
	wp_schedule_single_event(strtotime('first day of next month 00:00'), 'cfdb7_monthly_csv_event');
}

// Scheduled monthly email
add_action('cfdb7_monthly_csv_event', 'cfdb7_send_csv');

// Calendaly Cron

function calendly_send_csv($from = null, $to = null) {

    $admin_email = get_option('admin_email');
    $api_token   = 'eyJraWQiOiIxY2UxZTEzNjE3ZGNmNzY2YjNjZWJjY2Y4ZGM1YmFmYThhNjVlNjg0MDIzZjdjMzJiZTgzNDliMjM4MDEzNWI0IiwidHlwIjoiUEFUIiwiYWxnIjoiRVMyNTYifQ.eyJpc3MiOiJodHRwczovL2F1dGguY2FsZW5kbHkuY29tIiwiaWF0IjoxNzY2NTg2NDMwLCJqdGkiOiJiNjdhZTI3MS00ODlmLTQ2NzctYjY1MC0yOThlZDY3ZGZhZWYiLCJ1c2VyX3V1aWQiOiJjMzMxNTVkNC1hMWE5LTRkMDQtYjZjYy0wMDE3NWQ2MDZmN2QifQ.zz6mf10J7mIeR8CxpKJeL9_3QhlL_7A6O9OK7mJYoeHd_ocUVs6oHAGwk0nyXXyLrNWZGSt05uTRB8letdUBxQ';
    $organization = 'https://api.calendly.com/organizations/b48d5db8-6932-4644-a352-47d5ef0bd5a1';

    // AUTO DATE RANGE: Previous Month
    $from = date('Y-m-01', strtotime('first day of last month'));
    $to   = date('Y-m-t', strtotime('last day of last month'));

    // STEP 1: Get scheduled events
    $events_url = add_query_arg([
        'organization'   => $organization,
        'min_start_time' => "{$from}T00:00:00Z",
        'max_start_time' => "{$to}T23:59:59Z",
    ], 'https://api.calendly.com/scheduled_events');

    $events_response = wp_remote_get($events_url, [
        'headers' => [
            'Authorization' => 'Bearer ' . $api_token,
        ],
    ]);

    if (is_wp_error($events_response)) return;

    $events = json_decode(wp_remote_retrieve_body($events_response), true);
    if (empty($events['collection'])) return;

    // Create CSV
    $upload_dir = wp_upload_dir();
    $file_path = $upload_dir['basedir'] . "/calendly_{$from}_to_{$to}.csv";
    $fp = fopen($file_path, 'w');

    fputcsv($fp, [
        'Event Name',
        'Event Start Date',
        'Invitee Name',
        'Invitee Email',
        'Please share anything that will help prepare for our meeting.'
    ]);

    foreach ($events['collection'] as $event) {

        /* STEP 3: Get Invitees */
        $invitees_res = wp_remote_get($event['uri'] . '/invitees', [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_token,
            ],
        ]);

        if (is_wp_error($invitees_res)) continue;

        $invitees = json_decode(wp_remote_retrieve_body($invitees_res), true);

        foreach ($invitees['collection'] as $invitee) {

            $notes = '';

            if (!empty($invitee['questions_and_answers'])) {
                foreach ($invitee['questions_and_answers'] as $qa) {

                    if (
                        stripos(
                            $qa['question'],
                            'help prepare for our meeting'
                        ) !== false
                    ) {
                        $notes = $qa['answer'];
                        break;
                    }
                }
            }

            fputcsv($fp, [
                $event['name'] ?? '',
                $event['start_time'] ?? '',
                $invitee['name'] ?? '',
                $invitee['email'] ?? '',
                $notes,
            ]);
        }
    }

    fclose($fp);

    // Email CSV
    $subject = "Calendly Monthly Bookings Report ({$from} to {$to})";
    $body = "<p>Dear Admin,</p>
             <p>Please find attached Calendly bookings monthly report from <strong>{$from}</strong> to <strong>{$to}</strong>.</p>";

    wp_mail(
        $admin_email,
        $subject,
        $body,
        [
            'Content-Type: text/html; charset=UTF-8',
        ],
        [$file_path]
    );

    // Reschedule for the first day of the next calendar month.
    wp_schedule_single_event(strtotime('first day of next month 00:00'), 'calendly_monthly_report');
}


if (!wp_next_scheduled('calendly_monthly_report')) {
	wp_schedule_single_event(strtotime('first day of next month 00:00'), 'calendly_monthly_report');
}

add_action('calendly_monthly_report', 'calendly_send_csv');

/**
 * Improve LCP for custom logo
 */
add_filter('get_custom_logo', function ($html) {

    // Add fetchpriority="high"
    $html = str_replace(
        '<img',
        '<img fetchpriority="high" loading="lazy"',
        $html
    );

    return $html;
});
/**
 * Preload LCP logo
 */
/**
 * Preload LCP Logo
 */
add_action('wp_head', function () {

    $logo_id = get_theme_mod('custom_logo');
    if (!$logo_id) {
        return;
    }

    $logo_url  = wp_get_attachment_url($logo_id);
    $logo_type = get_post_mime_type($logo_id);

    if (!$logo_url || !$logo_type) {
        return;
    }
    ?>
    <link rel="preload"
          href="<?php echo esc_url($logo_url); ?>"
          as="image"
          type="<?php echo esc_attr($logo_type); ?>"
          loading="lazy">
<link rel="preload"
      href="<?php echo get_template_directory_uri(); ?>/fonts/webfonts/slick.woff"
      as="font"
      type="font/woff"
      crossorigin>

    <?php
    echo '<style>html { font-display: swap; }</style>';
});

add_action('wp_ajax_load_more_blogs', 'load_more_blogs');
add_action('wp_ajax_nopriv_load_more_blogs', 'load_more_blogs');

function load_more_blogs() {

    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $animation_blog_delay;

    $args = [
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 12,
        'paged'          => $paged,
        'order'          => 'DESC',
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post(); ?>

            <div class="our-blog col-lg-4 col-sm-6"
                 data-aos="fade-up"
                 data-aos-delay="<?php echo $animation_blog_delay; ?>"
                 data-aos-duration="1000">

                <?php $animation_blog_delay += 200; ?>

                <div class="content-wrap">
                    <a href="<?php the_permalink(); ?>" class="img-link">

                        <div class="images-contener">
                            <div class="imgs">
                                <?php if (has_post_thumbnail()) :
                                    the_post_thumbnail('medium_large', [
                                        'loading'  => 'lazy',
                                        'decoding' => 'async'
                                    ]);
                                else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/default-image.png" alt="">
                                <?php endif; ?>
                            </div>

                            <div class="meta">
                                <span class="date"><?php echo get_the_date('F d, Y'); ?></span>
                            </div>
                        </div>

                        <div class="content">
                            <h6 class="title"><?php the_title(); ?></h6>
                            <div class="short-desc"><?php the_excerpt(); ?></div>
                            <div class="buttons">
                                <span class="btn-readmore">Read More</span>
                            </div>
                        </div>

                    </a>
                </div>
            </div>

        <?php endwhile;
    endif;

    wp_reset_postdata();
    wp_die();
}

function add_acf_body_class($classes) {
    $custom_classes = get_field('body_custom_class');

    if (!empty($custom_classes) && is_array($custom_classes)) {
        foreach ($custom_classes as $class) {
            $classes[] = sanitize_html_class($class);
        }
    }

    return $classes;
}
add_filter('body_class', 'add_acf_body_class');



