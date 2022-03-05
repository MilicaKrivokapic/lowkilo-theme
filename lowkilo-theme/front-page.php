<?php get_header(); ?>


<div class="page-banner">
      <div
        class="page-banner__bg-image"
        style="background-image: url(<?php echo get_theme_file_uri('/images/glitter.jpg') ?>);">
        </div>
      <div class="page-banner__content container t-center c-white">
        <h1 class="headline headline--large-medium">01001000 01100101 01111001</h1>
        <h2 class="headline headline--small">
         Bye bye teary eys, hair loss and unused facial muscles.
        </h2>
        <h3 class="headline headline--tiny">
           Just forget <strong>all</strong> problems and give them Happy Days.
        </h3> </br>
        <a href="<?php echo get_post_type_archive_link('products'); ?>" class="btn btn--large btn--blue">Find the best solution</a>
      </div>
    </div>

    <div class="full-width-split group">
      <div class="full-width-split__one">
        <div class="full-width-split__inner">
          <h2 class="headline headline--small-plus t-center">
            Upcoming Events
          </h2>
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
                )
            )
          ));

          while($homepageEventit->have_posts()){
            $homepageEventit->the_post(); 
            get_template_part('template-parts/content', 'event');
         
             }
            ?>
         

          <p class="t-center no-margin">
            <a href="<?php echo get_post_type_archive_link('event'); ?>" class="btn btn--blue">View All Events</a>
          </p>
        </div>
      </div>
      <div class="full-width-split__two">
        <div class="full-width-split__inner">
          <h2 class="headline headline--small-plus t-center">From Our Blogs</h2> <?php 
          $homettiBlogPosts = new WP_Query(array 
          ('posts_per_page' => 2
          ));
          while ($homettiBlogPosts->have_posts()) {
            $homettiBlogPosts->the_post(); ?>
             <div class="event-summary">
            <a
              class="event-summary__date event-summary__date--beige t-center"
              href="<?php the_permalink();?>">
              <span class="event-summary__month"><?php the_time('M'); ?></span>
              <span class="event-summary__day"><?php the_time('D'); ?></span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny">
                <a href="<?php the_permalink();?>"><?php the_title();?></a>
              </h5>
              <p>
                <?php if (has_excerpt()) {
                echo get_the_excerpt(); }
                else {
                  echo wp_trim_words(get_the_content(), 10);
                }?>
                <a href="<?php the_permalink();?>" class="nu gray">Read more</a>
              </p>
            </div>
          </div>
            
            <?php
          } wp_reset_postdata();
          
          ?>

          <p class="t-center no-margin">
            <a href="<?php echo site_url('/blog/');?>" class="btn btn--yellow">View All Blog Posts</a>
          </p>
        </div>
      </div>
    </div>

    <div class="hero-slider">
      <div data-glide-el="track" class="glide__track">
        <div class="glide__slides">
          <div
            class="hero-slider__slide"
            style="background-image: url(<?php echo get_theme_file_uri('/images/milkshake-on-pink.jpg') ?>);">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">
                Help around the clock
                </h2>
                <p class="t-center">LOWKILO® offers genious custom solutions for bored and boring human pets.
                </p>
                <p class="t-center no-margin">
                  <a href="#" class="btn btn--blue">Learn more</a>
                </p>
              </div>
            </div>
          </div>
          <div
            class="hero-slider__slide"
            style="background-image: url(<?php echo get_theme_file_uri('images/omena.jpg') ?>);">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">
                  An Apple a Day
                </h2>
                <p class="t-center">
                  Our dentistry program recommends removing human teeth so they won't rot, <br> and it also prevents them for biting. Click here to learn <br> more about locations of our registered LOWKILO® dentistries. 
                </p>
                <p class="t-center no-margin">
                  <a href="#" class="btn btn--blue">Learn more</a>
                </p>
              </div>
            </div>
          </div>
          <div
            class="hero-slider__slide"
            style="background-image: url(<?php echo get_theme_file_uri('images/factory.jpg') ?>);">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">  Free Transportation to our HQ </h2>
                <p class="t-center">   
                  Free tour and entering to Happy Days laboratories and testing site. <br>
                  You can also meet our little test humans working <br> all day and night to ensure the product quality!  
                 
                </p>
                <p class="t-center no-margin">
                  <a href="#" class="btn btn--blue">Learn more</a>
                </p>
              </div>
            </div>
          </div>
        </div>
        <div
          class="slider__bullets glide__bullets"
          data-glide-el="controls[nav]"
        ></div>
      </div>
    </div>

    <?php 
    get_footer();
?>

