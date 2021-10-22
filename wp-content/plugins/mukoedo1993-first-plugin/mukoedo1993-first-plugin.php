<?php

/*
  Plugin Name: Our Test Plugin
  Description: A truly amazing plugin.
  Version: 1.0
  Author: TomKimi
  Author URI: https://github.com/mukoedo1993
*/


add_filter('the_content', 'addToEndOfPost'); 
//dynamically add a sentence to the very end of a blog post for
// the permalink or single view of posts.

function addToEndOfPost($content) {	//receive the default content given by the WP. 
	if (is_single() and is_main_query()) {
		return $content . '<p>My name is Tom Kimi.</p>';
	}
	else
	{
		
		return $content;
	}
 
}
?>
