<?php
add_action('rest_api_init','lowkiloRegisterSearch');

function lowkiloRegisterSearch() {
    register_rest_route('lowkilo/v1', 'search', array(
'methods' => WP_REST_SERVER::READABLE, 
'callback' => 'lowSearchResults'
    )); 
}
function lowSearchResults ($data) {
    $mainQuery = new WP_Query(array(
    'post_type' => array ('post', 'personnel', 'page', 'product','event' ),
    's' => sanitize_text_field($data['term'])
    ));

$results = array(
    'generalInfo' => array(),
    'products' => array(),
    'events' => array(),
    'personnels'=> array()
);

while ($mainQuery->have_posts()) {
$mainQuery->the_post();

if (get_post_type() == 'post' OR get_post_type() == 'page'){
    array_push($results['generalInfo'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'postType' => get_post_type(),
        'authorName'=> get_the_author()
        
        ));

}

if (get_post_type() == 'personnel'){
    array_push($results['personnels'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink()
        
        ));

}

if (get_post_type() == 'product'){
    array_push($results['products'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink()
        
        ));

}

if (get_post_type() == 'event'){
    $eventDate = new DateTime(get_field('event_date'));
    $description = NULL;
    if (has_excerpt()) {
$description = get_the_excerpt(); }
else {
$description = wp_trim_words(get_the_content(), 10);
        }
        array_push($results['events'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'month' => $eventDate->format('M'), 
        'day' =>  $eventDate->format('d'),
        'description' => $description

        
        ));

    }

}
return $results;


} 