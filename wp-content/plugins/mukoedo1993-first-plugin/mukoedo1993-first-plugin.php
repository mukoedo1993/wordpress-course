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
		
		add_action('admin_init', array( $this, 'settings'));
	}
	
	function settings () {
	
		add_settings_section('wcp_first_section', null, null, 'word-count-settings-page');	//first arg: the name of section; 2nd arg: the (sub)title of section; 2rd arg: a little bit of content, e.g.: generic HTML content; 4th arg: page slug we are going to add on.
	
		add_settings_field('wcp_location', 'Display Location', array($this, 'locationHTML'), 'word-count-settings-page', 'wcp_first_section');	//first argument: name of options setting we want to type into; 2nd arg: HTML label text; 3rd arg: method name; 4th arg: the page slug we are going to work with; 5th arg: the setting section you are going to add this field to.
		
		register_setting('wordcountplugin', 'wcp_location', array(
		'sanitize_callback' => 'sanitize_text_field', 'default' => '0'
		)); //first argument: name of group. second argument: specific setting. third argument: an array of stored values
	}//sanitize_text_field: a standardized WP function that will sanitize WP values for us.
	
	function locationHTML () { ?>
	
	<select name="wcp_location">
		<option value="0">Beginning of post</option>
		<option value="1">End of post</option>
	</select>
	
	<?php }
	
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
		<form action="options.php" method="POST">
		<?php
			settings_fields('wordcountplugin');	//name of group of settings; WP will babysit it.
			do_settings_sections('word-count-settings-page'); //slug for our settings page. WP will look for any section of settings we have registered.
			submit_button();
		?>
		</form> <!--wp knows the action here.-->
	</div>
<?php 
}


}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();




?>
