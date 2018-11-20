<?php 
$arg = [
    'post_type'     => 'post',
    'post_status'   => 'publish',
    'posts_per_page'=> 4
  ];
  $posts = new WP_Query($arg);

get_header();

?>

<div class="color_block"></div>
 <h1>2019 Iki Exchange</h1>
    <div class="subtitle">
    <p>Tiny text blurb about the program that can be about 1-2 sentences long…we should use sanafon btw</p>
    </div>
    <div class="slideshow">
        <div class="left">
        <?php 
            wp_nav_menu([
                'theme_location'  => 'main',
                'container'       => 'ul',
                'menu_id'      => 'nav',
                // 'menu_class'   => 'main',
            ]);
        ?>
        <!-- <ul id="nav">
            <li><a href="#">Home</a></li>
            <li><a href="#">Travel Guide</a></li>
            <li><a href="#">Photos</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Archive</a></li>
        </ul> -->
            <div class="slideshow_txt">
                    <p>Image block quote here: “This exchange was so rockin’ I would flunk
                         school just so I could keep participating in this exchange! More text so it forms a perfect block </p>
                </div>
        </div>
    <?php

        $images = get_field('main_gallery');

        if( $images ): ?>

        <div class="slideshow_img">
        
            <?php foreach( $images as $image ): ?>
                <div class="slide_wrap">
                    <img src="<?php echo $image['url']; ?>" />
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    </div>

    <div class="img_set">

    <?php if( get_field('set_of_images_1') ): ?>

            <img class="img_wrap" src="<?php the_field('set_of_images_1'); ?>" />

    <?php endif; ?> 
        <img class="img_wrap" src="https://via.placeholder.com/325x295" alt="img 2">
        <img class="img_wrap" src="https://via.placeholder.com/325x295" alt="img 3">
    </div>
    <div class="course_desc">
        <h2>Course Description</h2>
        <div class="course_txt">
        <?php echo get_field('course_desc'); ?>
        </div>
    </div>
    <h2>Member Experiences</h2>
<?php get_footer(); ?>