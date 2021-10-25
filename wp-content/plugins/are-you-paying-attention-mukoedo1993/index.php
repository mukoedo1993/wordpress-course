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
	add_action('enqueue_block_editor_assets', array($this, 'adminAssets') );
     }
     
     function adminAssets() {
      wp_enqueue_script('ournewblocktype',plugin_dir_url(__FILE__) . 'test.js', array('wp-blocks', 'wp-element')); 
      /*
      * 1st arg: the name we want to give to Javascript
      * 2nd arg: file's URL
      * 3rd arg: dependency loaded before WP load our own JS
      */
     }
}

$areYouPayingAttention = new AreYouPayingAttention();
