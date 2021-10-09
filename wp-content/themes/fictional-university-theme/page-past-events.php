<!--this file rendered for http://fictionaluniversity.local/past-events/-->
pageDASHpastDASHeventsDOTphp

<?php

get_header(); 

pageBanner(array(
  'title' => 'Past Events',
  'subtitle' => 'A recap of our past events.'
));
?>
    
<div class="container container--narrow page-section">	<!--A container div that our blog posts can live in.-->


<?php

  
$today = date('Ymd');
		
 $pastEvents = new WP_Query(array(
    'paged' => get_query_var('paged', 1),	//fetch information of current URL; if couldnt find, 2nd argument is the fallback No., here, i.e., one.
    
    'post_type' => 'event',
    'meta_key' => 'event_date' ,
    'orderby' => 'meta_value_num', //orderby number
    'order' => 'ASC',//'DESC' means descending, 'ASC' means ascending.
    'meta_query' => array(
      array(
      	'key' => 'event_date',//only previously
      	'compare' => '<',
      	'value' => $today, //'Ymd' stands for today
      	'type' => 'numeric'
      )
    )
    
 ));

 //if we call have_posts & the_post functions directly within the while loop,
 // we will see that the URL we are on is tied to a page,
 // that one single event page is the only item being queried. 
 //BUT we want to look up into pastEvents object.
  while($pastEvents->
  have_posts()) {
    $pastEvents->
    the_post(); 
      
    get_template_part('template-parts/content-event');
  }
  //pagination links
  echo paginate_links(array(
  	'total' => $pastEvents->max_num_pages
  ));

?>
</div>


<?php

get_footer();
?>
