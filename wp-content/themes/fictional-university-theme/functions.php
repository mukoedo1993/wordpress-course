<?php

#
require get_theme_file_path('/inc/search-route.php');

function university_custom_rest() {
	register_rest_field('post', 'authorName', array(
	  'get_callback' => function() {return get_the_author();}
	));
	
	
}

add_action('rest_api_init', 'university_custom_rest'); //first argument: hook; second argument: function name

function pageBanner($args = NULL /*default argument*/) {
  if (!$args['title']) {
   $args['title'] = get_the_title();
  }
  
    if (!$args['subtitle']) {
   $args['subtitle'] = get_field('page_banner_subtitle');
  }
  
    if (!$args['photo']) {
      if (get_field('page_banner_background_image') AND !is_archive() AND !is_home() ) {
      //If we don't add !is_archive and !is_home here, then, if the first event in the list of events
      //has a BG image our code can get confused and try to use it as the banner for the entire Archive page.
      	$args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
      } else {
      	$args['photo'] = get_theme_file_uri('/images/ocean.jpg');
      }
    }
  
  ?>
  <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>)"></div>
      <div class="page-banner__content container container--narrow">
      <?php //print_r($pageBannerImage);?>
        <h1 class="page-banner__title"><?php echo $args['title'];/*title function*/?></h1>
        <div class="page-banner__intro">
          <p><?php echo $args['subtitle']; ?></p>
        </div>
      </div>
    </div>
  <?php
}


function university_files() {



wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
//third argument: dependency of jquery
//fourth argument: version number for your script
//fifth argument: Do you want to load the file right before the closing body tag?


wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');//To make the text to use a custom font rather than a generic one
wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');  //fix the icon of 'Connect With Us' part
wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css')); 
wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css')); 


 #a WP function that allows us to output JS data into HTML source of the webpage.
   wp_localize_script('main-university-js', 'universityData', array(
    'root_url' => get_site_url(),
    
    /*
     * Whenever we successfullt logged into the WP, if we check the source, there will be secret
     * attribute named nonce, 
    */
    'nonce' => wp_create_nonce('wp_rest')
   )); //first argument: the JS file you are trying to make flexible. second 
   //argument: variable name, third argument: array of data we want to make available in JS.

}
//get_stylesheet_uri() if it is the 2nd argument, then , it mains merely load main.css file.

add_action('wp_enqueue_scripts', 'university_files');	//frist argument here tells to load css or js files
//second argument: our custom function

function university_features() {
//  register_nav_menu('headerMenuLocation', 'Header Menu Location'); //first argument: name for menu location second argument: text actually show up
//  register_nav_menu('footerLocationOne', 'Footer Location One'); 
  
//    register_nav_menu('footerLocationTwo', 'Footer Location Two'); 
  
  add_theme_support('title-tag');	//enable a feature for your theme: title-tag: This feature allows themes to add document title tag to HTML <head>.
  
   add_theme_support('post-thumbnails');
   
   add_image_size('professorLandscape', 400, 260, true); //nickname , wide, tall, crop or not. 
   
   add_image_size('professorPortrait', 480, 650, true);
   
   add_image_size('pageBanner', 1500, 350, true);
   
   
  
}




//Tell wordpress to automatically generate an appropriate title tag for each screen.
add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query) { //WP's query

	if (!is_admin() AND is_post_type_archive('program') AND is_main_query()) {
	
		//order alphabetically; override the default posts per page of 10 to infinity.
		$query->set('orderby', 'title');
		$query->set('order', 'ASC');
		$query->set('posts_per_page', -1);
	}




	if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) { //not on the admin page; // so we will never accidentally manipulate a custom query.// only true if it is a url-based query, like, here: http://fictionaluniversity.local/events/
	
	//$query->set('posts_per_page', '1'); //this line is very powerful. It by default will work on ALL of our pages, even including our backend editing pages.
	
	$today = date('Ymd');
	
	$query->set('meta_key', 'event_date');
	$query->set('orderby', 'meta_value_num');
	
	$query->set('order', 'ASC');
	
	$query->set('meta_query', array(
		      array(
		      	'key' => 'event_date',//only today or future's
		      	'compare' => '>=',
		      	'value' => $today, //'Ymd' stands for today
		      	'type' => 'numeric'
		      )
		    ));
	}

}


//manipulate event archive page:
add_action('pre_get_posts', 'university_adjust_queries'); // pre_get_posts here let our function to get access to the query object.

//  redirect subscriber account out of admin and onto homepage
add_action('admin_init', 'redirectSubsToFrontend');

function redirectSubsToFrontend() {
  $ourCurrentUser = wp_get_current_user();
  
  if (count($ourCurrentUser->roles) == 1 and $ourCurrentUser->roles[0] == 'subscriber') {
    wp_redirect(site_url('/'));//This will work even if we typed <domain-name>/wp-admin manually.
    exit; //tells PHP stop spinning its gears once it redirects sb.
  }

}


//  redirect subscriber account out of admin and onto homepage
add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar() {
  $ourCurrentUser = wp_get_current_user();
  
  if (count($ourCurrentUser->roles) == 1 and $ourCurrentUser->roles[0] == 'subscriber') {
	show_admin_bar(false); //unsets the display of the admin bar.
  }

}

# Customize Login Screen
add_filter('login_headerurl', 'ourHeaderUrl'); //the WP logo will redirect us to the homepage

function ourHeaderUrl() {
 return esc_url(site_url('/'));
}

add_action('login_enqueue_scripts', 'ourLoginCSS');

#customize CSS:
function ourLoginCSS() {
wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');//To make the text to use a custom font rather than a generic one
wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');  //fix the icon of 'Connect With Us' part
wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css')); 
wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css')); 
}


add_filter('login_headertitle', 'ourLoginTitle'); //customize the title of header of our login page.

function ourLoginTitle() {
  return get_bloginfo('name');
}
?>
