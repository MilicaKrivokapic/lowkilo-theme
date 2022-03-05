<?php
    
    get_header();
    while (have_posts()) {
        the_post();
        pageBanner();
        ?>
    <div class="container container--narrow page-section">  
    <div class="metabox metabox--position-up metabox--with-home-link"><p>
    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('products'); ?>"
    ><i class="fa fa-home" aria-hidden="true"></i> All Products</a>
      <span class="metabox__main"><?php the_title();?></span>
        </p>
      </div>
      <div style="display: flex; flex-flow: row wrap; gap: 15px;">
        <?php the_post_thumbnail('productImage'); ?> 
        <div class="generic-content"><?php the_content(); ?></div> 
      </div>

        
        <?php 
           $today = date('Ymd');
          $homepageEventit = new WP_Query(array
          ('posts_per_page' => 2,
            'post_type' => 'event',
            'meta_key'=> 'event_date',
            'orderby'=> 'meta_value',
            'order'=> 'ASC',
            'meta_query'=>array(
              array(
                'key'=> 'event_date',
                'compare'=> '>=',
                'value'=> $today,
                'type' => 'numeric'
              ),
              array(
                'key'=>'related_product',
                'compare'=>'LIKE',
                'value'=> '"' . get_the_ID() .'"'
              )
            )
          ));
          if ($homepageEventit->have_posts()){
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--small">Upcoming ' . get_the_title() . ' related events </h2>';
  
            while($homepageEventit->have_posts()){
              $homepageEventit->the_post(); ?>
             <div class="event-summary">
              <a class="event-summary__date t-center" href="#">
                <span class="event-summary__month">
                <?php 
                $eventDate = new DateTime(get_field('event_date'));
                echo $eventDate->format('M');
                ;?></span>
                <span class="event-summary__day">
                <?php echo $eventDate->format('d'); ?></span>
              </a>
              <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny">
                  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h5>
                <p>   <?php if (has_excerpt()) {
                  echo get_the_excerpt(); }
                  else {
                    echo wp_trim_words(get_the_content(), 10);
                  }?>
                  <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a>
                </p>
                
              </div>
            </div>
           
              <?php }
          }
     
            ?>

    </div>
    <?php }
        get_footer();
?>