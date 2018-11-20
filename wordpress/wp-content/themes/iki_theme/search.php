<?php 
$searched_string = $_GET['s'];
get_header(); ?>
  
<body>
   <div id="pink_rectangle"></div>
    <div id="dot_grid"></div>
    <div id="line_top"></div>
    <p class="search_title">Site Search</p>
    <!-- <form action="#">
     <div class="search"></div>
      <input type="text" placeholder="Search.." name="search">
    </form> -->
    <!-- <form role="search" action="<?php echo site_url('/'); ?>" method="get" class= "searchBar">
    <input type="search" id="s" name="s" placeholder="Search..."/>
        <button id="search_button" class="button">Search</button>
    </form> -->
    <?php if (have_posts()): ?>
    <div class="result_cont">
            <?php while (have_posts()) : the_post(); ?> 
            <div class="search_result">
                <p class="search_head"><a href="<?php the_permalink(); ?>"><?php the_title()?></p>
                <p><?php the_excerpt(); ?></p>
            </div>
            <?php endwhile; //resetting the page loop?>
            <?php wp_reset_query(); //resetting the page query?>
        <?php else: ?>
        <div class="search_result">
            <br>
            <br>
            <br>
            <br>
          <p class="h3" style="text-align: center;">Sorry, No Posts Found</p>
          <a href="<?php echo home_url(); ?>" id="search_button" class="button">Back Home</a>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
