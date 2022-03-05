<?php

require get_theme_file_path('/inc/search-route.php');

function lowkilo_custom_rest() {
    register_rest_field('post', 'authorName', array(
        'get_callback' => function () {return get_the_author();}
    ));
}

add_action('rest_api_init', 'lowkilo_custom_rest');

function pageBanner($args = NULL){
 if (!$args['title']){
   $args ['title'] = get_the_title();
 }
    if (!$args['subtitle']) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }

    if (!$args['photo']){
        if (get_field('page_banner_background_image')AND !is_archive() AND !is_home()){
        $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/glitter.jpg');
        }

    }


?> <div class="page-banner">
<div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo'];?>);"
></div>
<div class="page-banner__content container container--narrow">
  <h1 class="page-banner__title"><?php echo $args ['title']?></h1>
  <div class="page-banner__intro">
    <p> <?php echo $args['subtitle']?> </p>
  </div>
</div>
</div>
<?php }


function lowkilo_files() {
    
    wp_enqueue_style('custom-google-fonts','//fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Rubik:wght@300;400;600&display=swap');
    wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    
    if (strstr($_SERVER['SERVER_NAME'], 'lowkilo-made-for-your-pet-human.local')) {     
        wp_enqueue_script('main-lowkilo-js','http://localhost:3000/bundled.js', NULL, '1.0', true);
    } else {
        wp_enqueue_script('our-vendors-js',get_theme_file_uri('/bundled-assets/vendors~scripts.9678b4003190d41dd438.js'), NULL, '1.0', true);
        wp_enqueue_script('main-lowkilo-js',get_theme_file_uri('/bundled-assets/scripts.0eddbd80891821d4795d.js'), NULL, '1.0', true);
        wp_enqueue_style('main-styles', get_theme_file_uri('/bundled-assets/styles.0eddbd80891821d4795d.css'));
    }
wp_localize_script('main-lowkilo-js', 'lowkiloData', array(
    'root_url'=>get_site_url(),
));


}
add_action('wp_enqueue_scripts', 'lowkilo_files');

function lowkilo_features() {
    register_nav_menu('footerMenu1', 'Footer One Menu Location');
    register_nav_menu('footerMenu2', 'Footer Two Menu Location');

    register_nav_menu('HeaderMenu', 'Header Menu Location');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('personnelImage', 480, 650, true);
    add_image_size('pageBanner', 1500, 500, true);
    add_image_size('pageBannerRecommended', 1200, 628, true);
    add_image_size('productImage', 480, 400, true);

}
add_action('after_setup_theme', 'lowkilo_features');

function lowkilo_adjust_queries($query){
    if (!is_admin() AND is_post_type_archive('products') AND is_main_query()){
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);
    }
    
    if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()){
    $today = date('Ymd');
    $query->set('meta_key', 'event_date');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $query->set('meta_query',  array(
        array(
        'key'=> 'event_date',
        'compare'=> '>=',
        'value'=> $today,
        'type' => 'numeric'
        )
    ));
    }
    
}
add_action('pre_get_posts', 'lowkilo_adjust_queries');

//Redirektio subscriber-tason käyttäjille pois Dashboardista ja fronttisivulle
add_action('admin_init', 'redirectSubsToFrontend');

function redirectSubsToFrontend() {
  $ourCurrentUser = wp_get_current_user();

  if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
    wp_redirect(site_url('/'));
    exit;
  }
}

add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar() {
  $ourCurrentUser = wp_get_current_user();

  if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
    show_admin_bar(false);
  }
}

//Kustomoitu Login-screeni
add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl(){
return esc_url(site_url('/'));

}

add_action('login_enqueue_scripts', 'myLoginCSS');
function myLoginCSS(){
    wp_enqueue_style('main-styles', get_theme_file_uri('/bundled-assets/styles.0eddbd80891821d4795d.css'));
    wp_enqueue_style('custom-google-fonts','//fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Rubik:wght@300;400;600&display=swap');

}

add_filter('login_headertitle','ourLoginTitle');

function ourLoginTitle(){
return get_bloginfo('name');

}