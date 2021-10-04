<?php
function university_post_types() {
 
register_post_type('event',array(

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
 
}
 
 
//create a new post type:
add_action('init', 'university_post_types');
?>
