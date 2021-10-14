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


function universitySearchResults($data) { //WP could access the data here
	$mainQuery = new WP_query(array(
	'post_type' => array('post', 'page', 'professor','program','event'),
	's' => sanitize_text_field($data['term']) //s stands for search here. We need to sanitize the input here.
	)); //e.g.: http://fictionaluniversity.local/wp-json/university/v1/search?term=barksalot
	//search with the keyword of barksalot
	
	$results = array(
		'generalInfo' => array(),
		'professors' => array(),
		'programs' => array(),
		'events' => array()
	);
	
	while($mainQuery->have_posts()) {
		$mainQuery->the_post();
		
		if (get_post_type() == 'post' or get_post_type()== 'page') {
		  array_push($results['generalInfo'], array(
		  'title' => get_the_title(),
		  'permalink' => get_the_permalink(),
		  'postType'=> get_post_type(),
		  'authorName' => get_the_author()
		)); //first argument: destination array; second argument: what we want to add on the first array
		}
		
		if (get_post_type() == 'professor') {
		  array_push($results['professors'], array(
		  'title' => get_the_title(),
		  'permalink' => get_the_permalink(),
		  'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
		)); //first argument: destination array; second argument: what we want to add on the first array
		}
		
		if (get_post_type() == 'program') {
		  array_push($results['programs'], array(
		  'title' => get_the_title(),
		  'permalink' => get_the_permalink(),
		  'id' => get_the_id()
		)); //first argument: destination array; second argument: what we want to add on the first array
		}
		
		if (get_post_type() == 'event') {
		  $eventDate = new DateTime(get_field('event_date'));
		  
		  $description = null;
		  
		  if (has_excerpt()) {	//to create a new property named description here.
                  	$description = get_the_excerpt();
              		} else {
              		$description = wp_trim_words(get_the_content(), 18); //fallback if we doesn't have 
              		}
		
		  array_push($results['events'], array(
		  'title' => get_the_title(),
		  'permalink' => get_the_permalink(),
		  'month' => $eventDate->format('M'),
		  'day' => $eventDate->format('d'),
		  'description' => $description 
		)); //first argument: destination array; second argument: what we want to add on the first array
		}

	}
	
	if($results['programs']) {
		$programsMetaQuery = array('relation' => 'OR');
		/*
		'value' => '"'.$results['programs'][0]['id'] . '"' //loop through
		*/
		foreach($results['programs'] as $item){
			array_push($programsMetaQuery, array(
				'key' => 'related_programs',	
			  	'compare' => 'LIKE',
			  	'value' => '"'. $item['id'] . '"'
			));
		}
		
		
		$programRelationshipQuery = new WP_Query( array(
		  'post_type' => array('professor', 'event'),//query now will contain event and professor posts.
		  'meta_query' => $programsMetaQuery
		));
		
		#Loop through this query above and push each of the results onto
		while($programRelationshipQuery->have_posts()) {
		  $programRelationshipQuery->the_post();
		
		#Event type:
		if (get_post_type() == 'event') {
		  $eventDate = new DateTime(get_field('event_date'));
		  $description = null; 
	  	if (has_excerpt()) {	//to create a new property named description here.
          	$description = get_the_excerpt();
      		} else {
      		$description = wp_trim_words(get_the_content(), 18); //fallback if we doesn't have 
      		}
		
		  array_push($results['events'], array(
		  'title' => get_the_title(),
		  'permalink' => get_the_permalink(),
		  'month' => $eventDate->format('M'),
		  'day' => $eventDate->format('d'),
		  'description' => $description 
		));}
		
		
		# professor type:
		if (get_post_type() == 'professor') {
		  array_push($results['professors'], array(
		  'title' => get_the_title(),
		  'permalink' => get_the_permalink(),
		  'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
		)); //first argument: destination array; second argument: what we want to add on the first array
		}}
		#array_unique: remove duplication in our array:
		#array_values: https://www.php.net/manual/en/function.array-values
		$results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
		$results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
		//SORT_REGULAR means please look at each subitem of array to determine if they are duplicate or not.
		
		
		
	}
	
	
	return $results;
	
	//Here, wordpress will convert this array into a JS array.
}
?>
