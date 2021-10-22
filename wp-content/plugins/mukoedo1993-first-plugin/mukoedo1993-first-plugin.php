<?php

/*
  Plugin Name: Our Test Plugin
  Description: A truly amazing plugin.
  Version: 1.0
  Author: TomKimi
  Author URI: https://github.com/mukoedo1993
*/

//Wrap our methods in a class: benefits <= names of function could be much simpler compared to the case we place all functions in global scope.

class WordCountAndTimePlugin {
	function __construct() {
		add_action('admin_menu', array( $this , 'adminPage'));	//2nd argument must be a unique name for a function that has never been used by any other plugin. i.e.: $this=>adminPage();
	}
	
	function adminPage () {
	add_options_page('Word Count Settings', 'Word Count', 'manage_options', 'word-count-settings-page', array($this, 'ourHTML'));	//first argument: title of page we want to create;
	// second argument: text of title we use in the settings menu
	// third argument:  let only current user to see the page. 
	// fourth argument: end of URL for our settings page (slug)
	// fifth argument: function to produce HTML
}

	function ourHTML () { ?>
	<div class="wrap">
		<h1>Word Count Settings</h1>
	</div>
<?php 
}
}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();




?>
