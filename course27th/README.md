# Using The Modern Block Editor For Our Custom Post Type 
New custom post types will use the old classic Editor screen instead of the modern Block Editor screen unless we include a property named `show_in_rest` and set its value to `true` while registering our post type. Later in the course we'll learn all about what the REST API is, but for now, just know that we must include our new custom post type in it if we want our post type to leverage the modern block editor screen. To review, here's what your `university-post-types.php` file should look like with this new property included:
```
<?php
 
function university_post_types() {
  register_post_type('event', array(
    'public' => true,
    'show_in_rest' => true,
    'labels' => array(
      'name' => 'Events',
      'add_new_item' => 'Add New Event',
      'edit_item' => 'Edit Event',
      'all_items' => 'All Events',
      'singular_name' => 'Event'
    ),
    'menu_icon' => 'dashicons-calendar'
  ));
}
 
add_action('init', 'university_post_types');
```
Thanks!
Brad
