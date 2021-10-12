<?php

# customized search route here.
# http://fictionaluniversity.local/wp-json/university/v1/search
add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch() {
	register_rest_route('university/v1', 'search', array(
	'methods' => WP_REST_SERVER::READABLE,//Read data. A WP constant for set
	'callback' => 'universitySearchResults' //the value here is exactly the return value of function universitySearchResults
	
	));	//first argument: namespace you want to use, i.e.: wp; second argument: route, i.e.: posts OR pages;
	//third argument: an array describes what should happen when sb visits this URL.
}


function universitySearchResults() {
	$professors = new WP_query(array(
	'post_type' => 'professor'
	));
	
	$professorResults = array();
	
	while($professors->have_posts()) {
		$professors->the_post();
		array_push($professorResults, array(
		'title' => get_the_title(),
		'permalink' => get_the_permalink()
		)); //first argument: destination array; second argument: what we want to add on the first array
	}
	
	return $professorResults;
	
	//Here, wordpress will convert this array into a JS array.
}
?>
