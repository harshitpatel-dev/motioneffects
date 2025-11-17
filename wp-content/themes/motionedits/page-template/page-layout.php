<?php
/**
 * Template Name: Page Layout
 *
 * @package motionedits
 */

get_header();

if(have_posts()):
    while(have_posts()): 
        the_post();
        if(have_rows('sections')):
            ?>
            <main id="primary" class="site-main">
                <?php
                    while(have_rows('sections')):
                        the_row();
                        get_template_part('components/sections/'.get_row_layout());
                    endwhile;
                ?>
            </main>
            <?php
        else:
        ?>
        <!-- <section class="no-treatment not-added-acf common-page-template-layout top belleza_wrap">
            <div class="no-content">
                <div class="belleza-container">
                    <div class="belleza-container__title">
                        <h3><?php the_title(); ?></h3>
                        <p class="comming-soon-text pb-0">Comming Soon...</p>
                    </div>
                </div>
            </div>
        </section> -->

            <?php 
        endif;
    endwhile;
endif;

get_footer();