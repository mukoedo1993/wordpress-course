<?php

function university_files() {
wp_enqueue_style('university_main_styles', get_stylesheet_uri()); //load main.css file.

}

add_action('wp_enqueue_scripts', 'university_files');	//frist argument here tells to load css or js files
//second argument: our custom function
?>
