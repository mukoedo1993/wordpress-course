<?php

/*
  Plugin Name: Are You Paying Attention Mukoedo1993
  Description: Give your readers a multiple choice question
  Version 1.0
  Author: Tom Kim
  Author URI: https://github.com/mukoedo1993
*/

if(! defined( 'ABSPATH' )) exit; // Exit if accessed directly

class AreYouPayingAttention {
	function __construct() {
	add_action('init', array($this, 'adminAssets') );	//
     }
     
     function adminAssets() {
     
     wp_register_style('quizeditcss',plugin_dir_url(__FILE__) . 'build/index.css'); 
     //
     
      wp_register_script('ournewblocktype',plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element', 'wp-editor')); 
      /*
      * 1st arg: the name we want to give to Javascript
      * 2nd arg: file's URL
      * 3rd arg: dependency loaded before WP load our own JS
      */
      
      
      //dynamic post
      //We just need to refresh our frontend to see any change in our code, rather than manually go to the
      //editting page, and save our change manually.
      register_block_type('ourplugin/are-you-paying-attention', array(
       'editor_script' => 'ournewblocktype',	//tell block type to use our js file.
       'editor_style' => 'quizeditcss',	// tell block type to use our CSS file.
       'render_callback' => array($this, 'theHTML')
      ));
      /*
      * 2nd arg: an array of WP_Block_Type::__construct
      * See: https://developer.wordpress.org/reference/classes/wp_block_type/__construct/
      */
      
      
     }
     
     //output HTML:
     function theHTML($attributes) {
     	ob_start(); ?>
     	<h3>Today the sky is <?php echo esc_html($attributes['skyColor'])?> and the grass is <?php echo esc_html($attributes['grassColor'])?> !!!</h3>
     	<?php return ob_get_clean();
     }
}

$areYouPayingAttention = new AreYouPayingAttention();
