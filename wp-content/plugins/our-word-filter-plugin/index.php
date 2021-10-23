<?php
/*
  Plugin Name: Our Word Filter Plugin
  Description: A plugin to filter dirty words, like what China do.
  Version: 1.0
  Author: TomKimi
  Author URI: https://github.com/mukoedo1993
*/

if (! defined( 'ABSPATH' )) exit; // Exit if accessed directly

class OurWordFilterPlugin {

  function __construct() {
  	add_action('admin_menu', array($this, 'ourMenu'));
  }
  
  function ourMenu() {
  	add_menu_page('Words To Filter', 'Word Filter', 'manage_options'
  	, 'ourwordfilter', array($this , 'wordFilterPage'), 'dashicons-smiley', 100 );
  	/*
  	* 1st arg: page's title.
  	* 2nd arg: The text that will actually show up in the admin sidebar.
  	* 3rd arg: The permission or capability user needs to have or see the page.
  	* 4th arg: slug variable name of our menu
  	* 5th arg: function that outputs HTML for the actual page itself.
  	* 6th arg: icon shown in the admin sidebar.
  	* 7th arg: the number where our menu appears vertically
  	*/
  	
  	
  	add_submenu_page('ourwordfilter', 'Words To Filter', 'Words List', 'manage_options', 'ourwordfilter' , array($this, 'wordFilterPage') );
  	
  	add_submenu_page('ourwordfilter', 'Word Filter Options', 'Options', 'manage_options', 'word-filter-options' , array($this, 'optionsSubPage') );
  	/*
  	* 1st arg: the menu(4th arg from add_menu_page()) you want to add to submenu page to.
  	* 2nd arg: the actual document title you will see in the tab of browser
  	* 3rd arg: the text you actually see in the admin sidebar
  	* 4th arg: capability (here, manage_options allows us to see the page.)
  	* 5th arg: slug name or short name for the page. -> URL
  	* 6th arg: callback function
  	*/
  }
  
  function wordFilterPage() { ?>
  	Hello World!
  <?php }
  
  
  function optionsSubPage() { ?>
  	Hello World from the options page.
  <?php }

}


$ourWordFilterPlugin = new OurWordFilterPlugin();
