<?php

function university_files() {

wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
//third argument: dependency of jquery
//fourth argument: version number for your script
//fifth argument: Do you want to load the file right before the closing body tag?


wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');//To make the text to use a custom font rather than a generic one
wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');  //fix the icon of Connect With Us
wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css')); 
wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css')); 
}//get_stylesheet_uri() if it is the 2nd argument, then , it mains merely load main.css file.

add_action('wp_enqueue_scripts', 'university_files');	//frist argument here tells to load css or js files
//second argument: our custom function
?>
