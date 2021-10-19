<?php

add_action('rest_api_init', 'universityLikeRoutes'); //rest_api_init: when we want to add a new custom route, or a new field to the route.


function universityLikeRoutes() {
  register_rest_route('university/v1', 'manageLike', array(
  	'methods' => 'POST',
  	'callback' => 'createLike'
  ));	//first argument: beginning part of URL, known as namespace.
  	//second argument: name for this specific route, or URL.
  	
   register_rest_route('university/v1', 'manageLike', array(
  	'methods' => 'DELETE',
  	'callback' => 'deleteLike'
  ));

}


function createLike() {
	return 'Thanks for trying to create a like';
}

function deleteLike() {
	return 'Thanks for trying to delete a like';
}
