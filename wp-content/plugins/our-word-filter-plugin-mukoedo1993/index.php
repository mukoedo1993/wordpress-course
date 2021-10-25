<?php
/*
  Plugin Name: Our Word Filter Plugin mukoedo1993
  Description: A plugin to filter dirty words, like what China do.
  Version: 1.0
  Author: TomKimi
  Author URI: https://github.com/mukoedo1993
*/

if (! defined( 'ABSPATH' )) exit; // Exit if accessed directly

class OurWordFilterPlugin {

  function __construct() {
  	add_action('admin_menu', array($this, 'ourMenu'));
  	
  	add_action('admin_init', array($this, 'ourSettings'));
  	
  	if (get_option('plugin_words_to_filter')) {	//If this variable actually exists in our database
  		add_filter('the_content', array($this, 'filterLogic'));
  	}
  }
  
  function ourSettings() {
  	add_settings_section('replacement-text-section', null, null, 'word-filter-options');
  	/*
  	* 1st arg: the name of section
  	* 2nd arg: label text
  	* 3rd arg: description text
  	* 4th arg: slug name of the admin page 
  	*/
  	
  	register_setting('replacementFields', 'replacementText');
  	
  	add_settings_field('replacement-text', 'Filtered Text', array($this, 'replacementFieldHTML'), 'word-filter-options', 'replacement-text-section');
  	/*
  	* 1st arg: id attribute for an actual element
  	* 2nd arg: user will actually see on the form, for the label of the field
  	* 3rd arg: the function will output HTML for our field
  	* 4th arg: the slug of page you want to share on.
  	* 5th arg: the section you want to output the field to
  	*/
  }
  
  function replacementFieldHTML() {?>
  	<input type="text" name="replacementText" value="<?php echo esc_attr(get_option('replacementText', '***')); ?>">
  	<p class="description">Leave blank to simply remove the filtered words. </p>
  <?php }
  
  function filterLogic($content) {
  	$badWords = explode(',', get_option('plugin_words_to_filter') );
  	$badWordsTrimmed = array_map('trim', $badWords); //trimmed leading and trailing white spaces of each element in the array badWords
  	
  	return str_ireplace($badWordsTrimmed, esc_html(get_option('replacementText'), '****') , $content);	//China now! Censor every bad word!
  }
  
  function ourMenu() {
  	#PATH 1: commented: provide WP with our own file.
  	//add_menu_page('Words To Filter', 'Word Filter', 'manage_options'
  	//, 'ourwordfilter', array($this , 'wordFilterPage'), plugin_dir_url(__FILE__). 'banana.svg' , 100);
  	

  	#PATH 2: not commented: fully integrated...
  	$mainPageHook = add_menu_page('Words To Filter', 'Word Filter', 'manage_options'
  	, 'ourwordfilter', array($this , 'wordFilterPage'), 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCAzNzYuMjc3IDM3Ni4yNzciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDM3Ni4yNzcgMzc2LjI3NzsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTIiIGhlaWdodD0iNTEyIj4KPGc+Cgk8cGF0aCBzdHlsZT0iZmlsbDojQjI3MjE0OyIgZD0iTTMzOS4xMTQsMjc0LjAzNWMyNi41OC0yLjY3LDQwLjM2LDMwLjY4LDE5LjUyLDQ3LjM4Yy00LjcsMy43Ny05LjU2LDcuMzQtMTQuNTcsMTAuNzEgICBMMzM5LjExNCwyNzQuMDM1eiIvPgoJPHBhdGggc3R5bGU9ImZpbGw6I0IyNzIxNDsiIGQ9Ik01NC44NjQsMTcuNjQ1YzE2LjctMjAuODQsNTAuMDUtNy4wNiw0Ny4zOCwxOS41MWMtMC43Myw3LjE5LTEuMSwxNC40OC0xLjEsMjEuODZsLTYxLjIxLTIwLjI2ICAgQzQ0LjQ5NCwzMS40MTUsNDkuNDg0LDI0LjM2NSw1NC44NjQsMTcuNjQ1eiIvPgoJPHBhdGggc3R5bGU9ImZpbGw6I0Y3QjIzOTsiIGQ9Ik0zMzkuMTE0LDI3NC4wMzVsNC45NSw1OC4wOWMtMzQuNDIsMjMuMTUtNzUuODYsMzYuNjUtMTIwLjQ1LDM2LjY1ICAgYy0xMTkuNjksMC0yMTYuMTEtOTYuNDItMjE2LjExLTIxNi4xMWMwLTQxLjgxLDExLjg3LTgwLjg0LDMyLjQzLTExMy45MWw2MS4yMSwyMC4yNmMwLDExOS4yNyw5Ni44NCwyMTYuMTIsMjE2LjEyLDIxNi4xMSAgIEMzMjQuNjQ0LDI3NS4xMjUsMzMxLjkzNCwyNzQuNzU1LDMzOS4xMTQsMjc0LjAzNXoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiNFMDlCMkQ7IiBkPSJNNTQuMDAyLDE1Mi42NjZjMC0zNi40ODEsOS4wMzktNzAuODQ0LDI1LTEwMC45NzlMMzkuOTM0LDM4Ljc1NiAgIGMtMjAuNTYsMzMuMDctMzIuNDMsNzIuMS0zMi40MywxMTMuOTFjMCwxMTkuNjksOTYuNDIsMjE2LjExLDIxNi4xMSwyMTYuMTFjNy44NDMsMCwxNS41ODYtMC40MjYsMjMuMjE0LTEuMjQxICAgQzEzOC4xNjIsMzU1Ljk4NCw1NC4wMDIsMjY0LjQ4Niw1NC4wMDIsMTUyLjY2NnoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiNGRkZGRkY7IiBkPSJNMjUwLjUwNSwyOTYuMjI0Yy0wLjY5LDAtMS4zOTMtMC4wOTYtMi4wODktMC4yOTdjLTM5LjU0Mi0xMS40NDQtNzYuMDI2LTMzLjA3Ny0xMDUuNTA5LTYyLjU2ICAgYy0zMy4xNC0zMy4xNC01Ni4wMzktNzQuNTQ4LTY2LjIyMi0xMTkuNzQ5Yy0wLjkxLTQuMDQxLDEuNjI4LTguMDU1LDUuNjY4LTguOTY1YzQuMDQyLTAuOTA5LDguMDU1LDEuNjI3LDguOTY1LDUuNjY4ICAgYzkuNTU5LDQyLjQyOCwzMS4wNjUsODEuMzA5LDYyLjE5NSwxMTIuNDM5YzI3LjY5NywyNy42OTcsNjEuOTU2LDQ4LjAxNSw5OS4wNzIsNTguNzU3YzMuOTc5LDEuMTUxLDYuMjcxLDUuMzEsNS4xMTksOS4yODkgICBDMjU2Ljc1NiwyOTQuMDg5LDI1My43NTgsMjk2LjIyNCwyNTAuNTA1LDI5Ni4yMjR6Ii8+Cgk8Y2lyY2xlIHN0eWxlPSJmaWxsOiNGRkZGRkY7IiBjeD0iNzguNTY3IiBjeT0iNzkuNDI4IiByPSI3LjUiLz4KCTxnPgoJCTxwYXRoIHN0eWxlPSJmaWxsOiMzMzMzMzM7IiBkPSJNMzczLjYzNSwyODcuNzE0Yy01Ljg4NC0xNC40MDMtMTkuNzQxLTIyLjcwNS0zNS4yNjctMjEuMTM4Yy02Ljk2MiwwLjctMTQuMDYzLDEuMDU0LTIxLjEwNywxLjA1NCAgICBjLTU1LjY4MywwLTEwOC4wNi0yMS43MS0xNDcuNDgyLTYxLjEzM2MtMzkuNDIzLTM5LjQyMy02MS4xMzMtOTEuOC02MS4xMzItMTQ3LjQ4M2MwLTcuMDQsMC4zNTUtMTQuMTQsMS4wNTUtMjEuMTA1ICAgIGMxLjU2Mi0xNS41NC02LjczNi0yOS4zODMtMjEuMTM5LTM1LjI2NkM3NC4yMzktMy4yMDgsNTguNzE0LDAuODQyLDQ5LjAwNywxMi45NThDMTcuNDA1LDUyLjQwNCwwLDEwMi4wMTksMCwxNTIuNjY0ICAgIGMwLDU5Ljg4OSwyMy4yMTUsMTE2LjA4Nyw2NS4zNywxNTguMjQyYzQyLjE1NCw0Mi4xNTUsOTguMzUyLDY1LjM3MSwxNTguMjQxLDY1LjM3MWM1MC42NDYsMCwxMDAuMjYyLTE3LjQwNCwxMzkuNzA4LTQ5LjAwNyAgICBDMzc1LjQzNiwzMTcuNTYzLDM3OS40ODUsMzAyLjAzNiwzNzMuNjM1LDI4Ny43MTR6IE02MC43MTMsMjIuMzM3YzQuMjg4LTUuMzUyLDkuNjUtNy4zMDEsMTQuNjMxLTcuMzAxICAgIGMyLjcwNiwwLDUuMjk5LDAuNTc2LDcuNTQ2LDEuNDkzYzYuNDQ3LDIuNjM0LDEyLjk1NSw5LjIzOSwxMS44ODYsMTkuODhjLTAuNDA5LDQuMDY5LTAuNjk3LDguMTgyLTAuODg1LDEyLjMwM0w1MS41MzUsMzQuNjk0ICAgIEM1NC40MzIsMzAuNDksNTcuNDg2LDI2LjM2Niw2MC43MTMsMjIuMzM3eiBNNzUuOTc3LDMwMC4yOTlDMzYuNjU1LDI2MC45NzgsMTUsMjA4LjU0NywxNSwxNTIuNjY0ICAgIGMwLTM3LjUwOCw5LjY4MS03My4yNiwyOC4yMi0xMDQuOTIybDUwLjQ5MywxNi43MTFjMS4zNjgsNTcuNjU0LDI0LjQ5LDExMS42OCw2NS40NTksMTUyLjY1ICAgIGM0Mi4yNTYsNDIuMjU2LDk4LjM5OSw2NS41MjcsMTU4LjA4OSw2NS41MjZjNSwwLDEwLjAyNC0wLjE4MywxNS4wMTgtMC41MTRsMy45MzIsNDYuMjE5ICAgIGMtMzMuNTEsMjEuNjE0LTcyLjAyNywzMi45NDItMTEyLjU5OSwzMi45NDJDMTY3LjcyOSwzNjEuMjc3LDExNS4yOTgsMzM5LjYyMSw3NS45NzcsMzAwLjI5OXogTTM1My45NCwzMTUuNTY0ICAgIGMtMS4xNjgsMC45MzYtMi4zNDQsMS44NTgtMy41MjcsMi43NjZsLTMuMDg1LTM2LjI1N2M2LjMzOSwxLjczOCwxMC40NjksNi41MzcsMTIuNDIsMTEuMzEzICAgIEMzNjIuMzU1LDI5OS43NjksMzYyLjE5OSwzMDguOTQ3LDM1My45NCwzMTUuNTY0eiIvPgoJCTxwYXRoIHN0eWxlPSJmaWxsOiMzMzMzMzM7IiBkPSJNMjgzLjc3OCwzMTcuNjA0Yy01LjY3OSwwLjQ2My0xMS40NjQsMC42OTgtMTcuMTkyLDAuNjk4Yy01NS44ODIsMC0xMDguMzEzLTIxLjY1Ni0xNDcuNjM1LTYwLjk3OCAgICBjLTM5LjMyMS0zOS4zMjItNjAuOTc2LTkxLjc1My02MC45NzYtMTQ3LjYzNmMwLTguMjY3LDAuNDg4LTE2LjU5LDEuNDUxLTI0Ljc0YzAuNDg2LTQuMTEzLTIuNDU1LTcuODQyLTYuNTY4LTguMzI4ICAgIGMtNC4xMTEtMC40ODMtNy44NDIsMi40NTUtOC4zMjgsNi41NjhjLTEuMDMyLDguNzMxLTEuNTU1LDE3LjY0Ny0xLjU1NSwyNi41YzAsNTkuODg5LDIzLjIxNSwxMTYuMDg3LDY1LjM3LDE1OC4yNDIgICAgczk4LjM1Myw2NS4zNzEsMTU4LjI0MSw2NS4zNzFjNi4xMzUsMCwxMi4zMjktMC4yNTEsMTguNDEzLTAuNzQ4YzQuMTI4LTAuMzM3LDcuMjAxLTMuOTU3LDYuODY1LTguMDg1ICAgIEMyOTEuNTI2LDMyMC4zNDEsMjg3LjkwMywzMTcuMjY3LDI4My43NzgsMzE3LjYwNHoiLz4KCTwvZz4KPC9nPgoKCgoKCgoKCgoKCgoKCgo8L3N2Zz4=');
    	/*
  	* 1st arg: page's title.
  	* 2nd arg: The text that will actually show up in the admin sidebar.
  	* 3rd arg: The permission or capability user needs to have or see the page.
  	* 4th arg: slug variable name of our menu
  	* 5th arg: function that outputs HTML for the actual page itself.
  	* 6th arg: icon shown in the admin sidebar. (here, banana.svg)
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
  	
  	
  	add_action("load-{$mainPageHook}", array($this, 'mainPageAssets')); 
  	//1st arg: load the hook returned above
  	// 2nd arg: method we want to run
  }
  
  function mainPageAssets () {
   wp_enqueue_style('filterAdminCss', plugin_dir_url(__FILE__) . 'styles.css');
  
  }
  
  function handleForm() {
  
  	if (wp_verify_nonce($_POST['ourNonce'], 'saveFilterWords') and current_user_can('manage_options')) 
  	//wp_verify_nonce(): 1st arg: the nonce value we saw on our browser; 2nd arg: action name we made up.
  	//current_user_can(): 
  	{	
  	update_option('plugin_words_to_filter', sanitize_text_field($_POST['plugin_words_to_filter']) );
   /*
   * 1st param: name of option we want to store this value as in the Database.
   * 2nd param: the value we want to store in database.
   */
    ?>
    <div class="updated">
     <p>Your filtered words were saved. </p>
    </div>
   <?php
  	} else { ?>
	  	<div class="error">
	  		<p>Sorry, you don't have permission to do this operation.</p>
	  	</div>
  	<?php }
    }
    
  
  function wordFilterPage() { ?>
  	<div class="wrap">
  	<h1>Word Filter</h1>
  	<?php if ($_POST['justsubmitted'] == "true") $this->handleForm() ?>
  	<form method="POST">
  	 <input type="hidden" name="justsubmitted" value="true">
  	   <?php wp_nonce_field('saveFilterWords', 'ourNonce'); ?>
  		<label for="plugin_words_to_filter"><p>Enter a <strong >comma-separated list of words to filter from your site's content.</strong> </p></label>
  		<div class="word-filter__flex-container">
			<textarea name="plugin_words_to_filter" id="plugin_words_to_filter" placeholder="bad, mean, awful, horrible"><?php echo esc_textarea(get_option('plugin_words_to_filter')); ?></textarea>  		
  		</div>
  		<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
  	</form>
  	</div>
  <?php }
  
  
  function optionsSubPage() { ?>
  	<div class="wrap">
  	 <h1>Word Filter Options</h1>
  	 <form action="options.php" method="POST">
  	  <?php 
  	   
  	   settings_errors(); //setting API will call you if you are the setting's page.
  	   
  	   settings_fields('replacementFields'); //group name
  	   
  	   do_settings_sections('word-filter-options');
  	  
  	   submit_button();
  	  ?>
  	 </form>
  	</div>
  <?php }

}


$ourWordFilterPlugin = new OurWordFilterPlugin();
