<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch() {
	register_rest_route('university/v1', 'search', array(
	'methods' => WP_REST_SERVER::READABLE,//Read data. A WP constant for set
	'callback' => 'universitySearchResults'
	
	));	//first argument: namespace you want to use, i.e.: wp; second argument: route, i.e.: posts OR pages;
	//third argument: an array describes what should happen when sb visits this URL.
}


function universitySearchResults() {
	return 'Congratulations, you created a route';
}
?>
