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

    // Font Awesome
    wp_enqueue_style(
        'motionedits-fontawesome',
        get_template_directory_uri() . '/css/all.min.css',
        [],
        '6.6.0'
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
        unset( $value->response['advanced-custom-fields-pro-master/acf.php'] );
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

// 'display'  => __('Once Monthly'),
add_filter('cron_schedules', function ($schedules) {
    $schedules['monthly'] = [
        'interval' => MONTH_IN_SECONDS,
		'display'  => __('Once Monthly'),
    ];
    return $schedules;
});

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
        'From: <' . $admin_email . '>'
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
}

if (!wp_next_scheduled('cfdb7_monthly_csv_event')) {
	$timestamp = strtotime('first day of next month 00:00');
	error_log('Scheduling cron event now');
    //wp_schedule_event(time(), 'monthly', 'cfdb7_monthly_csv_event');
//     wp_schedule_single_event($timestamp, 'monthly', 'cfdb7_monthly_csv_event');
	wp_schedule_event($timestamp, 'monthly', 'cfdb7_monthly_csv_event');
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
        ['Content-Type: text/html; charset=UTF-8'],
        [$file_path]
    );
}


if (!wp_next_scheduled('calendly_monthly_report')) {
	$timestamp = strtotime('first day of next month 00:00');
   //wp_schedule_event(time(), 'monthly', 'calendly_monthly_report');
//     wp_schedule_single_event($timestamp, 'monthly', 'calendly_monthly_report');
	wp_schedule_event($timestamp, 'monthly', 'calendly_monthly_report');
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



