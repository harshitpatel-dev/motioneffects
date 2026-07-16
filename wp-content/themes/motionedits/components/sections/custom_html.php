<?php 
$custom_html  = get_sub_field('custom_html', false);
$esc_html     = get_sub_field('esc_html');
$custom_class = get_sub_field('custom_class');
//var_dump($esc_html);
?>

<section class="motion-wrap <?php echo esc_attr($custom_class); ?>">
    <div class="motion-container">
        <?php
        if ($esc_html) {
            // Strip tags + escape + keep line breaks
            print_r($custom_html);
        } else {
            echo $custom_html;
        }
        ?>
    </div>
</section>
