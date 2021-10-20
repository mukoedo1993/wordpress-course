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
	$professor = sanitize_text_field($data['professorId']);

	wp_insert_post(array(
		'post_type' => 'like',
		'post_status' => 'publish',
		'post_title' => '2nd PHP Test',
		'meta_input' => array(	// meta-keyname ARROW meta-value
		  'liked_professor_id' => $professor
		)	
	));
}

function deleteLike() {
	return 'Thanks for trying to delete a like';
}
