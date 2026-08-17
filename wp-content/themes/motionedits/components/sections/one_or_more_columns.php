<?php
$section_id = get_sub_field('section_id');
$custom_class = get_sub_field('custom_class');
$section_bg_color = get_sub_field('bg_color');
$show_elements = get_sub_field('show_elements');
$columns_title = get_sub_field('columns_title');
$description = get_sub_field('description');

// Simple animation delay counter (ms)
$animation_delay = 0;

// Set to true by the Grid item when a mobile-only slider is needed
$mobile_slider_column = false;
?>
<section class="two-column-content motion-wrap <?php echo $custom_class; ?>" <?= !empty($section_id) ? 'id="' . htmlspecialchars($section_id) . '"' : '' ?> style="background-color: <?php echo $section_bg_color ?>;">
    <div class="motion-container">
        <div class="two-column-content-wrapper">
            <?php if (in_array('Title', $show_elements)): ?>
                <div class="column-sub-desc-main-title" <?php if (!empty($columns_title) || !empty($description)) { ?>data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000" <?php $animation_delay += 200;
                } ?>>
                    <div
                        class="column-main-title <?php if (in_array('Description', $show_elements)): ?>description<?php endif; ?>">
                        <?php if (in_array('Title', $show_elements) && $columns_title): ?>
                            <h3 class="title"><?php echo $columns_title; ?></h3>
                        <?php endif; ?>
                    </div>

                    <?php if (in_array('Description', $show_elements) && $description): ?>
                        <div class="desc text-center" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>"
                            data-aos-duration="1000">
                            <?php echo $description; ?>
                        </div>
                        <?php $animation_delay += 200; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Multi Column -->
            <?php if (get_sub_field('columns')): ?>
                <div class="multi_columns" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>"
                    data-aos-duration="1000">
                    <?php $animation_delay += 200; ?>
                    <div class="multi_columns_content">
                        <div class="video_image_content row justify-content-center">

                            <?php
                            $columns = get_sub_field('columns'); // Get the columns repeater field
                            $column_count = count($columns); // Count the number of columns
                        
                            // Loop through columns
                            foreach ($columns as $column):
                                $custom_class = $column['custom_class'];
                                $column_class = is_array($column['column_class']) ? implode(' ', $column['column_class']) : $column['column_class'];
                                $items = $column['items'];
                                ?>

                                <?php if ($items): ?>
                                    <div
                                        class="column-items <?php echo esc_attr($column_class); ?> <?php echo esc_attr($custom_class); ?>">
                                        <div class="content-wrap h-100">
                                            <?php foreach ($items as $item):
                                                $type = $item['type'];
                                                $title = $item['title'];
                                                $sub_title = $item['sub_title'];
                                                $image = $item['image'];
                                                $video = $item['video_items'];
                                                $text = $item['text'];
                                                $show_rotate = $item['show_rotate'];
                                                $buttons = $item['buttons'];
                                                $contact_details = $item['contact_details'];
                                                $social_icons = $item['social_icons'];
                                                $contact_form = $item['contact_form'];
                                                $grid = $item['grid'];
                                                $grid_type = $item['grid_type'];
                                                $desktop_slider = $item['desktop_slider'];
                                                $process_steps = $item['process_steps'];
                                                $calendly = $item['calendly'];
											
											$is_svg = !empty($image['url']) && pathinfo($image['url'], PATHINFO_EXTENSION) === 'svg';
                                                ?>

                                                <?php if ($type === "Sub Title" && $sub_title): ?>
                                                    <div class="item" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>"
                                                        data-aos-duration="1000">
                                                        <h3><?php echo $sub_title; ?></h3>
                                                    </div>
                                                    <?php $animation_delay += 200; ?>

                                                <?php elseif ($type === "Title" && $title): ?>
                                                    <div class="item" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>"
                                                        data-aos-duration="1000">
                                                        <h3 class="title"><?php echo $title; ?></h3>
                                                    </div>
                                                    <?php $animation_delay += 200; ?>

                                                <?php elseif ($type === "Video"):
                                                        $video_type = $video['video_type'];
                                                        $video_file = $video['video_file'];
                                                        $video_link = $video['video_link'];
                                                        $thumbnail  = $video['video_thumbnail'];

                                                        // Work out which player we're dealing with so we can show the
                                                        // matching play button and build the right embed URL.
                                                        // The iframe is NOT rendered here - it's injected on click, so
                                                        // playback counts as a user gesture and is allowed to have sound.
                                                        $player    = 'file';
                                                        $embed_url = '';
                                                        $yt_id     = '';

                                                        if ($video_type === 'Link' && $video_link) {
                                                            if (preg_match('~(?:youtube\.com/(?:watch\?v=|embed/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{11})~', $video_link, $m)) {
                                                                $player    = 'youtube';
                                                                $yt_id     = $m[1];
                                                                $embed_url = 'https://www.youtube.com/embed/' . $yt_id . '?autoplay=1&rel=0&playsinline=1';
                                                            } elseif (preg_match('~vimeo\.com/(?:video/)?(\d+)(?:/([A-Za-z0-9]+))?(?:\?h=([A-Za-z0-9]+))?~', $video_link, $m)) {
                                                                $player    = 'vimeo';
                                                                $embed_url = 'https://player.vimeo.com/video/' . $m[1] . '?autoplay=1&playsinline=1';
                                                                // Unlisted/private videos need their hash or the embed is rejected
                                                                $vimeo_hash = !empty($m[2]) ? $m[2] : (!empty($m[3]) ? $m[3] : '');
                                                                if ($vimeo_hash !== '') {
                                                                    $embed_url .= '&h=' . $vimeo_hash;
                                                                }
                                                            } else {
                                                                $player    = 'embed';
                                                                $embed_url = $video_link . (strpos($video_link, '?') !== false ? '&' : '?') . 'autoplay=1';
                                                            }
                                                        }

                                                        // Poster: use the ACF thumbnail, else fall back to YouTube's own still
                                                        $poster = $thumbnail;
                                                        if (!$poster && $yt_id) {
                                                            $poster = 'https://img.youtube.com/vi/' . $yt_id . '/maxresdefault.jpg';
                                                        }
                                                    ?>
                                                     <div class="item" data-aos="fade-up"
                                                        data-aos-delay="200" data-aos-duration="800">

                                                        <div class="video-block mb-2">
                                                            <?php if (($video_type === 'File' && $video_file) || $embed_url): ?>
                                                                <div class="video-player video-player--<?php echo esc_attr($player); ?>"
                                                                    data-player="<?php echo esc_attr($player); ?>"
                                                                    <?php if ($embed_url): ?>data-src="<?php echo esc_url($embed_url); ?>"<?php endif; ?>>

                                                                    <?php if ($player === 'file'): ?>
                                                                        <video playsinline preload="metadata"
                                                                            <?php if ($poster): ?>poster="<?php echo esc_url($poster); ?>"<?php endif; ?>>
                                                                            <source src="<?php echo esc_url($video_file); ?>" type="video/mp4">
                                                                        </video>
                                                                    <?php elseif ($poster): ?>
                                                                        <img class="video-player__poster" src="<?php echo esc_url($poster); ?>"
                                                                            alt="" loading="lazy">
                                                                    <?php endif; ?>

                                                                    <button type="button" class="video-play-btn" aria-label="Play video">
                                                                        <?php if ($player === 'youtube'): ?>
                                                                            <!-- YouTube: wide red rounded rectangle, white triangle -->
                                                                            <svg class="video-play-btn__icon" viewBox="0 0 68 48" aria-hidden="true">
                                                                                <path class="yt-bg" d="M66.5 7.7a8.6 8.6 0 0 0-6-6C55.2 0 34 0 34 0S12.8 0 7.5 1.7a8.6 8.6 0 0 0-6 6A89.9 89.9 0 0 0 0 24a89.9 89.9 0 0 0 1.5 16.3 8.6 8.6 0 0 0 6 6C12.8 48 34 48 34 48s21.2 0 26.5-1.7a8.6 8.6 0 0 0 6-6A89.9 89.9 0 0 0 68 24a89.9 89.9 0 0 0-1.5-16.3z"/>
                                                                                <path d="M27 34V14l18 10z" fill="#fff"/>
                                                                            </svg>
                                                                        <?php elseif ($player === 'vimeo'): ?>
                                                                            <svg class="video-play-btn__icon" viewBox="0 0 72 72" aria-hidden="true">
                                                                                <circle class="fl-bg" cx="36" cy="36" r="36"/>
                                                                                <path class="fl-tri" d="M29 50V22l22 14z"/>
                                                                            </svg>
                                                                        <?php else: ?>
                                                                            <!-- Uploaded file: solid white circle with a dark triangle -->
                                                                            <svg class="video-play-btn__icon" viewBox="0 0 72 72" aria-hidden="true">
                                                                                <circle class="fl-bg" cx="36" cy="36" r="36"/>
                                                                                <path class="fl-tri" d="M29 50V22l22 14z"/>
                                                                            </svg>
                                                                        <?php endif; ?>
                                                                    </button>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <?php $animation_delay += 200; ?>


                                                <?php elseif ($type === "Image" && $image): ?>
                                                    <div class="item h-100" data-aos="fade-up"
                                                        data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                                                        <div class="item_image">

															<img 
                                                                src="<?php echo esc_url($image['url']); ?>" 
                                                                alt="<?php echo esc_attr($image['alt'] ?: ''); ?>" 
                                                                <?php if (!$is_svg): ?>
                                                                    width="<?php echo esc_attr($image['width']); ?>" 
                                                                    height="<?php echo esc_attr($image['height']); ?>"
                                                                <?php endif; ?>
                                                                loading="lazy">
                                                        </div>
                                                    </div>
                                                    <?php $animation_delay += 200; ?>

                                                <?php elseif ($type === "Text" && $text): ?>
                                                    <div class="item" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>"
                                                        data-aos-duration="1000">
                                                        <div class="description"><?php echo $text; ?></div>
                                                    </div>
                                                    <?php $animation_delay += 200; ?>

                                                <?php elseif ($type === "Button" && $buttons): ?>
                                                    <div class="item" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>"
                                                        data-aos-duration="1000">
                                                        <?php if ($show_rotate): ?>
                                                            <div class="button_section rotation-mobile">
                                                                <?php foreach ($buttons as $button):
                                                                    $button_link = $button['button_url'];
                                                                    $button_name = $button['button_name'];
                                                                    $btn_class = $button['btn_class'];
                                                                    ?>
                                                                    <a href="<?php echo $button_link; ?>"
                                                                        class="btn <?php echo $btn_class; ?>"><?php echo $button_name; ?></a>
                                                                <?php endforeach; ?>
                                                            </div>
                                                            <div class="button_section pt-0 rotation-desktop">
                                                                <?php foreach ($buttons as $button):
                                                                    $button_link = $button['button_url'];
                                                                    $button_name = $button['button_name'];
                                                                    ?>
                                                                    <a href="<?php echo $button_link; ?>">
                                                                        <div class="circle-btn style3">
                                                                            <svg viewBox="0 0 150 150" class="svg-hidden">
                                                                                <path id="about-tbn" d="M 0,75 a 75,75 0 1,1 0,1 z"></path>
                                                                            </svg>
                                                                            <div class="btn-icon"><img fetchpriority="high" loading="eager"
                                                                                    src="<?php echo get_template_directory_uri(); ?>/images/phone-icon.svg"
                                                                                    alt="" loading="eager"></div>
                                                                            <div class="btn-text">
                                                                                <svg viewBox="0 0 150 150">
                                                                                    <text>
                                                                                        <textPath href="#about-tbn">
                                                                                            <?php echo $button_name; ?>&nbsp;.&nbsp;<?php echo $button_name; ?>&nbsp;.&nbsp;<?php echo $button_name; ?>&nbsp;.&nbsp;
                                                                                        </textPath>
                                                                                    </text>
                                                                                </svg>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="button_section">
                                                                <?php foreach ($buttons as $button):
                                                                    $button_link = $button['button_url'];
                                                                    $button_name = $button['button_name'];
                                                                    $btn_class = $button['btn_class'];
                                                                    ?>
                                                                    <a href="<?php echo $button_link; ?>"
                                                                        class="btn <?php echo $btn_class; ?>"><?php echo $button_name; ?></a>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php $animation_delay += 200; ?>

                                                <?php elseif ($type === "Contact Details" && !empty($contact_details)): ?>
                                                    <div class="item" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>"
                                                        data-aos-duration="1000">
                                                        <ul class="contactDetail">
                                                            <?php foreach ($contact_details as $detail):
                                                                $detail_type = $detail['type'];
                                                                ?>
                                                                <?php if ($detail_type === 'Email' && !empty($detail['email'])): ?>
                                                                    <li class="email">
                                                                        <p class="detail-title">Email:</p>
                                                                        <a
                                                                            href="mailto:<?php echo esc_attr($detail['email']); ?>"><?php echo esc_html($detail['email']); ?></a>
                                                                    </li>
                                                                <?php elseif ($detail_type === 'Phone' && !empty($detail['phone'])): ?>
                                                                    <li class="phone">
                                                                        <p class="detail-title">Phone:</p>
                                                                        <a
                                                                            href="tel:<?php echo esc_attr($detail['phone']); ?>"><?php echo esc_html($detail['phone']); ?></a>
                                                                    </li>
                                                                <?php elseif ($detail_type === 'Address' && !empty($detail['address'])): ?>
                                                                    <li class="address">
                                                                        <p class="detail-title">Address:</p>
                                                                        <?php echo $detail['address']; ?>
                                                                    </li>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                    <?php $animation_delay += 200; ?>

                                                <?php elseif ($type === "Social Icons" && !empty($social_icons)): ?>
                                                    <div class="item" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>"
                                                        data-aos-duration="1000">
                                                        <div class="social-details">
                                                            <div class="detail-title">Follow us:</div>
                                                            <ul class="socialMenu">
                                                                <?php foreach ($social_icons as $icon):
                                                                    $menu_label = $icon['menu_label'];
                                                                    $menu_link = $icon['menu_link'];
                                                                    if (empty($menu_link))
                                                                        continue;
                                                                    ?>
                                                                    <li>
                                                                        <a href="<?php echo esc_url($menu_link); ?>"
                                                                            title="<?php echo esc_attr($menu_label); ?>" target="_blank">
                                                                            <span class="imgs">
                                                                                <?php if ($menu_label === 'Facebook'): ?>
                                                                                    <i class='bx bxl-facebook'></i>
                                                                                <?php elseif ($menu_label === 'Instagram'): ?>
                                                                                    <i class='bx bxl-instagram'></i>
                                                                                <?php elseif ($menu_label === 'Linkedin'): ?>
                                                                                    <i class='bx bxl-linkedin'></i>
                                                                                <?php elseif ($menu_label === 'Vimeo'): ?>
                                                                                    <i class='bx bxl-vimeo'></i>
                                                                                <?php endif; ?>
                                                                            </span>
                                                                        </a>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <?php $animation_delay += 200; ?>

                                                <?php elseif ($type === "Contact Form" && $contact_form): ?>
                                                    <div class="item" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>"
                                                        data-aos-duration="1000">
                                                        <div class="contact-section"><?php echo $contact_form; ?></div>
														<div class="thankyou-section" style="display: none;">
                                                            <h3 class="success-title">Thank you for showing interest in our services.</h3>
                                                            <p class="modal-message">We have received your inquiry and excited to explore the opportunity of working together.</p>
                                                            <p class="modal-message">Please allow us 24 hours to reply to your request. </p>
                                                            <p class="modal-signature">Talk to you soon,<br><strong>Motion Edits</strong></p>
                                                        </div>
                                                    </div>
											<script>
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
                                                        </script>
                                                    <?php $animation_delay += 200; ?>

                                                <?php elseif ($type === "Grid" && $grid): ?>
                                                    <div class="grid_column item" data-aos="fade-up"
                                                        data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                                                        <div class="grid_column_columns">
                                                            <?php
                                                            // Set default values
                                                            $slider_class = '';
                                                            $width = ($grid_type === 'Text Title Grid') ? 'col-sm-6 col-md-4 col-lg-6 col-xl-6' : 'col-sm-6 col-lg-4 col-xl-4';
                                                            if ($grid_type === 'Text Title Grid' && $desktop_slider) {
                                                                $width = 'col-sm-6 col-lg-4 col-xl-3';
                                                                $slider_class = 'inner-column-slider ';
                                                            } elseif ($grid_type === 'Text Title Grid' && !$desktop_slider) {
                                                                $slider_class = 'mobile-column-slider ';
                                                                $mobile_slider_column = 'true';
                                                            }
                                                            $grid_count = count($grid);
                                                            $grid_odd_class = ($grid_count % 2 !== 0) ? ' odd-grid' : '';
                                                            ?>

                                                            <div
                                                                class="row justify-content-center <?php echo $grid_odd_class; ?> <?php echo $slider_class; ?>">
                                                                <?php foreach ($grid as $value):
                                                                    $image = $value['icon'] ?? '';
                                                                    $title = $value['title'] ?? '';
                                                                    $description = $value['description'] ?? '';
                                                                    $text_title = $value['text_title'] ?? '';
                                                                    $grid_show_rotate = $value['show_rotate'];
                                                                    $grid_buttons = $value['buttons'];
                                                                    $grid_show_button = $value['show_button'];
                                                                    if ($grid_show_button)
                                                                        $width .= ' button-grid';
                                                                    ?>
                                                                    <div class="grid <?php echo $width; ?>">
                                                                        <div class="grid_column_columns-inner content-wrap">
                                                                            <?php if (!empty($title) || !empty($text_title)): ?>
                                                                                <div class="content-titles">
                                                                                    <?php if ($image && $grid_type == "Image Grid"): ?>
                                                                                        <div class="iconWrap"><img loading="lazy"
                                                                                                src="<?php echo esc_url($image); ?>" alt=""></div>
                                                                                    <?php endif; ?>
                                                                                    <?php if ($text_title && $grid_type == "Text Title Grid"): ?>
                                                                                        <h3 class="text_title"><?php echo $text_title; ?></h3>
                                                                                    <?php endif; ?>
                                                                                    <?php if ($title): ?>
                                                                                        <h6 class="title"><?php echo $title; ?></h6><?php endif; ?>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                            <?php if ($description): ?>
                                                                                <div class="content-description">
                                                                                    <?php echo wp_kses_post($description); ?></div><?php endif; ?>
                                                                            <?php if ($grid_show_button):
                                                                                ob_start(); ?>
                                                                                <div class="grid_button item">
                                                                                    <?php if ($grid_buttons) {
                                                                                        if ($grid_show_rotate) {
                                                                                            $grid_button_link = $grid_buttons['button_url'];
                                                                                            $grid_button_name = $grid_buttons['button_name'];
                                                                                            $grid_btn_class = $grid_buttons['btn_class']; ?>
                                                                                            <div class="button_section rotation-mobile"><a
                                                                                                    href="<?php echo $grid_button_link; ?>"
                                                                                                    class="btn <?php echo $grid_btn_class; ?>"><?php echo $grid_button_name; ?></a>
                                                                                            </div>
                                                                                            <div class="button_section pt-0 rotation-desktop"><a
                                                                                                    href="<?php echo $grid_button_link; ?>">
                                                                                                    <div class="circle-btn style3"><svg
                                                                                                            viewBox="0 0 150 150" class="svg-hidden">
                                                                                                            <path id="about-tbn"
                                                                                                                d="M 0,75 a 75,75 0 1,1 0,1 z"></path>
                                                                                                        </svg>
                                                                                                        <div class="btn-icon"><img fetchpriority="high"
                                                                                                                loading="lazy"
                                                                                                                src="<?php echo get_template_directory_uri(); ?>/images/phone-icon.svg"
                                                                                                                alt=""></div>
                                                                                                        <div class="btn-text"><svg
                                                                                                                viewBox="0 0 150 150"><text>
                                                                                                                    <textPath href="#about-tbn">
                                                                                                                        <?php echo $grid_button_name; ?>&nbsp;.&nbsp;<?php echo $grid_button_name; ?>&nbsp;.&nbsp;<?php echo $grid_button_name; ?>&nbsp;.&nbsp;
                                                                                                                    </textPath>
                                                                                                                </text></svg></div>
                                                                                                    </div>
                                                                                                </a></div>
                                                                                        <?php } else { ?>
                                                                                            <div class="button_section"><a
                                                                                                    href="<?php echo $grid_buttons['button_url']; ?>"
                                                                                                    class="btn <?php echo $grid_buttons['btn_class']; ?>"><?php echo $grid_buttons['button_name']; ?></a>
                                                                                            </div>
                                                                                        <?php }
                                                                                    } ?>
                                                                                </div>
                                                                                <?php $button_html = ob_get_clean();
                                                                                echo $button_html; endif; ?>
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php $animation_delay += 200; ?>

                                                <?php elseif ($type === "Process Steps" && !empty($process_steps) && is_array($process_steps)): ?>
                                                    <div class="process-steps-wrapper" data-aos="fade-up"
                                                        data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                                                        <span class="process-timeline"></span>
                                                        <div class="process-steps">
                                                            <?php $row_index = 1;
                                                            foreach ($process_steps as $process_step):
                                                                $icon = $process_step['step_icon'];
                                                                $title = $process_step['step_title'];
                                                                $desc = $process_step['step_description']; ?>
                                                                <div class="process-card">
                                                                    <div class="process-card-inner">
                                                                        <div class="process-icon"><?php if (!empty($icon)): ?><img
                                                                                    src="<?php echo esc_url($icon); ?>"
                                                                                    alt="<?php echo esc_attr($title); ?>"><?php endif; ?></div>
                                                                        <div class="process-content">
                                                                            <h5><?php echo esc_html($title); ?></h5>
                                                                            <p><?php echo esc_html($desc); ?></p>
                                                                        </div>
                                                                        <div class="process-number"><?php echo esc_html($row_index); ?></div>
                                                                    </div>
                                                                </div>
                                                                <?php $row_index++; endforeach; ?>
                                                        </div>
                                                    </div>
                                                    <?php $animation_delay += 200; ?>

                                                <?php elseif ($type === 'Calendly' && $calendly): ?>
                                                    <div class="calendly-grid item" data-aos="fade-up"
                                                        data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                                                        <div class="grid_column_columns">
                                                            <?php $calendly_index = 1; ?>
                                                            <div class="row justify-content-center">
                                                                <?php foreach ($calendly as $value):
                                                                    $select_option = $value['select_option'];
                                                                    $image = $value['icon'] ?? '';
                                                                    $title = $value['title'] ?? '';
                                                                    $description = $value['description'] ?? '';
                                                                    if ($calendly_index % 2 == 0) {
                                                                        $calendly_column_width = "col-xl-6 col-lg-12 no-bg-color candely_$calendly_index";
                                                                    } else {
                                                                        $calendly_column_width = "col-xl-3 col-sm-6 candely_$calendly_index";
                                                                    }
                                                                    ?>
                                                                    <div class="grid <?php echo $calendly_column_width; ?>">
                                                                        <div class="grid_column_columns-inner content-wrap">
                                                                            <?php if ($select_option === 'Grid' && (!empty($image) || !empty($title))): ?>
                                                                                <div class="content-titles"><?php if (!empty($image)): ?>
                                                                                        <div class="iconWrap"><img loading="lazy"
                                                                                                src="<?php echo esc_url($image); ?>" alt=""></div>
                                                                                    <?php endif; ?>                            <?php if (!empty($title)): ?>
                                                                                        <h6 class="title"><?php echo $title; ?></h6><?php endif; ?>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                            <?php if (!empty($description)): ?>
                                                                                <div class="content-description">
                                                                                    <?php echo wp_kses_post($description); ?></div><?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                    <?php $calendly_index++; endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php $animation_delay += 200; ?>

                                                <?php endif; ?>

                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>


<?php if ($mobile_slider_column): ?>
    <script>
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
    </script>
<?php endif; ?>

<script>
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
</script>

<?php
// Click-to-play handler for the inline video players.
// Printed only once per page even though this section can repeat.
if (!defined('MOTIONEDITS_VIDEO_PLAYER_JS')) {
    define('MOTIONEDITS_VIDEO_PLAYER_JS', true);
    ?>
    <script>
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
    </script>
    <?php
}
?>
