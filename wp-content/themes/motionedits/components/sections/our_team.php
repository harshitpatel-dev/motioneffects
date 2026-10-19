<?php
$show_elements = get_sub_field('show_elements');
$title = get_sub_field('title');
$description = get_sub_field('description');
$team_members = get_sub_field('team_members');
$custom_class = get_sub_field('custom_class');
$bg_color = get_sub_field('bg_color');
// animation delay counter (ms)
$animation_delay = 0;
?>

<section class="ourTeam_wrapper motion-wrap <?php echo esc_attr($custom_class); ?>"
    style="background-color: <?php echo $bg_color ?>">
    <div class="motion-container">
        <div class="ourTeam_wrapper-container">
            <?php if (in_array('Title', $show_elements)): ?>
                <div class="column-sub-desc-main-title pb-0" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                    <?php $animation_delay += 200; ?>
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

            <?php if (!empty($team_members)): ?>
                <div class="ourTeam_items">
                    <?php $index = 0;
                    foreach ($team_members as $team_member):
                        $member_name = $team_member['member_name'];
                        $member_image = $team_member['member_image'];
                        $member_designation = $team_member['member_designation'];
                        $member_bio = $team_member['member_bio'];
                        $reverse = ($index % 2 !== 0);
                        list($member_image_width, $member_image_height) = motionedits_get_image_dimensions($member_image);
                        ?>
                        <div class="ourteam_row" data-aos="fade-up" data-aos-delay="<?php echo $animation_delay; ?>" data-aos-duration="1000">
                            <?php $animation_delay += 100; ?>
                            <div class="items image-item <?php echo $reverse ? 'order-two' : 'order-one'; ?>">
                                <div class="content-wrap">
                                    <div class="image-border">
                                        <div class="image_wrapper">
                                            <img src="<?php echo esc_url($member_image); ?>" alt="<?php echo esc_attr($member_name); ?>" <?php if (!empty($member_image_width) && !empty($member_image_height)): ?>width="<?php echo esc_attr($member_image_width); ?>" height="<?php echo esc_attr($member_image_height); ?>"<?php endif; ?> loading="lazy">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="items content-item <?php echo $reverse ? 'order-one' : 'order-two'; ?>">
                                <div class="content-wrap">
                                    <div class="member-title">
                                        <h1><?php echo esc_html($member_name); ?></h1>
                                    </div>
                                    <div class="designation"><h6><?php echo esc_html($member_designation); ?></h6></div>
                                    <div class="member-bio">
                                        <?php echo wp_kses_post($member_bio); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $index++; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>

    </div>
</section>