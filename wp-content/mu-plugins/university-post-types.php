<?php
function university_post_types() {
 
register_post_type('event',array(
 
  'public' => true,
 
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
