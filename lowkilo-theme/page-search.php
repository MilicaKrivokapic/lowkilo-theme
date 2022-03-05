<?php
    get_header();

    while (have_posts()) {
        the_post(); 
        pageBanner();
        ?>
      

    <div class="container container--narrow page-section">
      
      <?php 
      $vanhempi = wp_get_post_parent_id(get_the_ID());
     if ($vanhempi) { ?>
  <div class="metabox metabox--position-up metabox--with-home-link"><p>
    <a class="metabox__blog-home-link" href="<?php echo get_permalink ($vanhempi); ?>"
    ><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($vanhempi); ?></a>
      <span class="metabox__main"><?php the_title();?></span>
        </p>
      </div>
<?php 
     }
      ?>
     
      <?php 
      $testiArray = get_pages(array
      ('child_of' => get_the_ID()
      ));
      if ($vanhempi or $testiArray) { ?>
      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($vanhempi); ?>"><?php echo get_the_title($vanhempi);?></a></h2>
        <ul class="min-list">
         <?php 
         if ($vanhempi) {
              $findChildrenOf = $vanhempi;   
         } else {
              $findChildrenOf = get_the_ID();
         }
            wp_list_pages(array(
              'title_li' => NULL,
              'child_of' => $findChildrenOf
        
            ));
         ?>
        </ul>
      </div>
      <?php } ?>
      <div class="generic-content">
      <?php get_search_form();?>
    </div>
         

    <?php }

    get_footer();
?>
