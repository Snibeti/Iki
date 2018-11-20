<?php
/*
 * Template Name: Individual Page
 * Template Post Type: post, page, product
 */
get_header(); 
$categories = get_categories(); ?>
<!--blog body-->
<h2>2019 Iki Exchange</h2>
<h2 class="japan">粋 交 換</h2>

        <?php 
            wp_nav_menu([
                'theme_location'  => 'main',
                'container'       => 'ul',
                'menu_id'      => 'single_nav',
                // 'menu_class'   => 'main',
            ]);
        ?>
    <div class="banner">
    <div class="banner_title"><?php echo get_field('page_title'); ?></div>
    <div class="banner_img" style="background-image: url(<?php echo get_field('banner_image'); ?>);"></div>
        <!-- <img src="https://via.placeholder.com/1100x430" alt="banner"> -->
     </div>   
<?php
    if( have_rows('section') ): ?>
    <div class="single_grid">
    <?php while ( have_rows('section') ) : the_row(); ?>
        <div class="section_head"><?php the_sub_field('section_header');?></div>
        <div class="section_body"><?php the_sub_field('section_text');?></div>
    <?php endwhile;

        else : ?>

    // no rows found
    </div>
   <?php endif; ?>
    
<?php get_footer(); ?>