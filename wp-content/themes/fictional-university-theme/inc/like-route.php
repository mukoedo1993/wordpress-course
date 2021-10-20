<?php

add_action('rest_api_init', 'universityLikeRoutes'); //rest_api_init: when we want to add a new custom route, or a new field to the route.


function universityLikeRoutes() {
  register_rest_route('university/v1', 'manageLike', array(
  	'methods' => 'POST',
  	'callback' => 'createLike'
  ));	//first argument: beginning part of URL, known as namespace.
  	//second argument: name for this specific route, or URL.
  	//callback function will be passed with data
  	
   register_rest_route('university/v1', 'manageLike', array(
  	'methods' => 'DELETE',
  	'callback' => 'deleteLike'
  ));

}


function createLike($data) {
	if (is_user_logged_in()) {
	
	$professor = sanitize_text_field($data['professorId']);
	
	$existQuery = new WP_Query(array(
		    		  'author' => get_current_user_id(), 
		    		  'post_type' => 'like',
		    		  'meta_query' => array(
		    		  	array(
		    		  	 'key' => 'liked_professor_id',
		    		  	 'compare' => '=',
		    		  	 'value' => $professor
		    		  	)
		    		  )	//We need it because we only want to pull in like posts, where the like professor ID
		    		  			//value matches the ID of the current professor page you are viewing. 
		    		));
	if ($existQuery->found_posts == 0 and get_post_type($professor) == 'professor') {	//To make sure the user have not yet liked the professor and the id number is not fake
	  return wp_insert_post(array(
		'post_type' => 'like',
		'post_status' => 'publish',
		'post_title' => '2nd PHP Test',
		'meta_input' => array(	// meta-keyname ARROW meta-value
		  'liked_professor_id' => $professor
		)	
	));
	} else {
		die("Invalid profesor id");
	}
 
    } else {
    	die("Only logged in users can create a like. ");
    }	


}

function deleteLike() {
	return 'Thanks for trying to delete a like';
}
