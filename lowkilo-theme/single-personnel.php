<?php
    
    get_header();
    while (have_posts()) {
        the_post(); 
        pageBanner();
        ?>


    <div class="container container--narrow page-section">  
    <div class="container container--narrow page-section">  
    <div class="metabox metabox--position-up metabox--with-home-link"><p>
    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('personnel'); ?>"
    ><i class="fa fa-home" aria-hidden="true"></i> Personnel </a>
      <span class="metabox__main"><?php the_title();?></span>
        </p>
      </div>
  
<div class="generic-content">
     <div class="row group">
    
    <div class="one-third"> 
        <div clas="round-personnel-image">
    <?php the_post_thumbnail('personnelImage'); ?>
    </div>
    </div>

    <div class="two-thirds">
    <?php the_content(); ?>
           </div>
    
    </div>
   </div>
    <?php }
        get_footer();
?>