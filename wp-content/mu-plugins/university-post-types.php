<?php
function university_post_types() {
 
register_post_type('event',array(

# Event Post Type

  'supports' => array('title', 'editor' , 'excerpt'), //So we can modify event's excerpts. editor means we have modern editor.

  'rewrite' => array('slug' => 'events'),//so we could use<domain>/events to visit all events here, rather than ../event

  'has_archive' => true,
 
  'public' => true,
  
  'show_in_rest' => true, //Our new editor in WP relies almost exclusively on JS, so
  //order for it to work, we need to make sure that custom post type shows up within the rest API.
 
  'labels' => array(
 
    'name' => 'Events',
    'add_new_item' => 'Add New Event',
    'edit_item' => 'Edit Event',
    'all_items' => 'All Events',
    'singular_name' => 'Event'
 
  ), //sidebar using Events now; and add new event is displayed rather than add new post.
 
  'menu_icon' => 'dashicons-calendar' //dashicons-calendar
 
));
//first argument: the name of type of post; second argument: array of different options describe your custom post type; third argument: icon of the event used in the menu




#  Program Post Type 
 register_post_type('program',array(

# Event Post Type

  'supports' => array('title', 'editor' ), //So we can modify event's excerpts. editor means we have modern editor. We dont need excerpt here.

  'rewrite' => array('slug' => 'programs'),//so we could use<domain>/events to visit all events here, rather than ../event

  'has_archive' => true,
 
  'public' => true,
  
  'show_in_rest' => true, //Our new editor in WP relies almost exclusively on JS, so
  //order for it to work, we need to make sure that custom post type shows up within the rest API.
 
  'labels' => array(
 
    'name' => 'Programs',
    'add_new_item' => 'Add New Program',
    'edit_item' => 'Edit Program',
    'all_items' => 'All Programs',
    'singular_name' => 'Program'
 
  ), //sidebar using Events now; and add new event is displayed rather than add new post.
 
  'menu_icon' => 'dashicons-awards' //dashicons-awards
 
));


#  Professor Post Type 
 register_post_type('professor',array(

  'show_in_rest' => true, //to show this URL, professor, in our customized rest API(in course 70th)

  'supports' => array('title', 'editor', 'thumbnail' ), //thumbnail to enable featured image for the post type: Professors

  //'rewrite' => array('slug' => 'professors'), //we do not need to rewrite the slug(url)

  //'has_archive' is not needed here. Because professor doesn't need archive.
 
  'public' => true,
  
  'show_in_rest' => true, 
  'labels' => array(
 
    'name' => 'Professors',
    'add_new_item' => 'Add New Professor',
    'edit_item' => 'Edit Professor',
    'all_items' => 'All Professor',
    'singular_name' => 'Professor'
 
  ), 
 
  'menu_icon' => 'dashicons-welcome-learn-more' 
 
));
}
 
add_action('init', 'university_post_types');
?>
