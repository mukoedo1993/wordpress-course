# Quick Fix For Page Banner Function

Our Page Banner function works well in many situations, however, when used on an archive page (for example the All Events page/query)
<br> if the first event in the list<br>
of events has a background image our code can get confused and try to use it as the banner for the entire Archive page.<br>

To fix this and avoid potential errors in the next lesson, I want you to make a modification to your page banner function code right now. <br>
Essentially, inside the if condition where we check to see if the current post has a banner image custom field value or not... <br>
<br>we want to add two more conditions to make sure the current query is not an archive or a blog listing. <br>
<br>Below is the entire updated code for our pageBanner function: <br>

```
function pageBanner($args = NULL) {
  
  if (!$args['title']) {
    $args['title'] = get_the_title();
  }
 
  if (!$args['subtitle']) {
    $args['subtitle'] = get_field('page_banner_subtitle');
  }
 
  if (!$args['photo']) {
    if (get_field('page_banner_background_image') AND !is_archive() AND !is_home() ) {
      $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
    } else {
      $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
    }
  }
```

The **AND !is_archive() AND !is_home()** is the new addition / fix.<br>

Thanks!<br>
Brad
