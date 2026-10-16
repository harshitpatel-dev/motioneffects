<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package motionedits
 */
$current_host = strtolower($_SERVER['HTTP_HOST'] ?? '');

$is_video_editor_subdomain = ($current_host === 'video-editor.motionedits.com');
$is_vfx_subdomain          = ($current_host === 'vfx.motionedits.com');

$is_landing_subdomain = $is_video_editor_subdomain || $is_vfx_subdomain;

/*
|--------------------------------------------------------------------------
| GTM Container
|--------------------------------------------------------------------------
|
| Main Domain          -> GTM-MNMLJWPZ
| Video Editor Domain  -> GTM-TST2NBSR
| VFX Domain           -> No GTM yet
|
*/

$gtm_id = null;

if ($is_video_editor_subdomain || $is_vfx_subdomain) {
    $gtm_id = 'GTM-TST2NBSR';
} elseif (!$is_vfx_subdomain) {
    $gtm_id = 'GTM-MNMLJWPZ';
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>

    <?php if ($gtm_id) : ?>
        <!-- Google Tag Manager -->
            <script>
            (function(w,d,s,l,i){
                w[l]=w[l]||[];
                w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});
                var f=d.getElementsByTagName(s)[0],
                    j=d.createElement(s),
                    dl=l!='dataLayer'?'&l='+l:'';
                j.async=true;
                j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;
                f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','<?php echo esc_js($gtm_id); ?>');
            </script>
        <!-- End Google Tag Manager -->
    <?php endif; ?>
	
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Google Search Console Code -->
    <meta name="google-site-verification" content="glvFueQNRt5Fig_AuS-Z4Nik4U-QV9ylPBfqwzliP4Q" />
	<!-- End Google Search Console Code -->
	
	<link rel="profile" href="https://gmpg.org/xfn/11">
	
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/fonts/webfonts/boxicons.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/fonts/roboto/roboto-regular.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="<?php echo get_template_directory_uri(); ?>/fonts/roboto/roboto-medium.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="<?php echo get_template_directory_uri(); ?>/fonts/roboto/roboto-bold.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/fonts/liberation-sans/liberationsans-regular.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="<?php echo get_template_directory_uri(); ?>/fonts/liberation-sans/liberationsans-bold.woff2" as="font" type="font/woff2" crossorigin>
	
	<link rel="preconnect" href="https://assets.calendly.com" crossorigin>
    <link rel="preconnect" href="https://calendly.com" crossorigin>
	
	<?php wp_head(); ?>
	
<?php if (!$is_landing_subdomain) : ?>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-TQJ5NRPT4D"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-TQJ5NRPT4D');
  gtag('config', 'AW-10860440795');
</script>
	<!-- End Google tag (gtag.js) -->
	<?php endif; ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ($gtm_id) : ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe
            src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr($gtm_id); ?>"
            height="0"
            width="0"
            style="display:none;visibility:hidden">
        </iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
<?php endif; ?>

	
<div id="page" class="site">

	<header id="masthead" class="site-header fixed-top">
		<div class="motion-container">
			<div class="row">
				<div class="site-branding">
					<?php the_custom_logo(); ?>
				</div><!-- .site-branding -->

				<nav id="site-navigation" class="main-navigation">
					<!-- <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php // esc_html_e( 'Primary Menu', 'motionedits' ); ?></button> -->
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
							)
						);
					?>
				</nav><!-- #site-navigation -->

				<div class="contact-wrapper">
						<a class="btn-contact" href="<?php echo home_url(); ?>/contact-us"><span>Contact Us</span> <i class='bx bx-right-arrow-alt'></i></a>
				</div>

			</div>
		</div>
	</header><!-- #masthead -->
