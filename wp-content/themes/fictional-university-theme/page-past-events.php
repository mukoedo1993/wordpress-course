<!--this file rendered for http://fictionaluniversity.local/past-events/-->


<?php

get_header(); ?>
	  <div class="page-banner"> <!--banner-->
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">Past Events</h1>
        <div class="page-banner__intro">
          <p>A recap of our past events.</p>
        </div>
      </div>
    </div>
    
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

 //if we call have_posts & the_post functions directly within the while loop, we want to look up into pastEvents object.
  while($pastEvents->have_posts()) {
    $pastEvents->the_post(); ?>
       <div class="event-summary">
             <a class="event-summary__date t-center" href="#">
              <span class="event-summary__month"><?php 
               $eventDate = new DateTime(get_field('event_date')); //DateTime's ctor takes the date of event_date custom field.
               echo $eventDate->format('M');	//Return the three-letter representation of Month.
               ?></span>
              <span class="event-summary__day"><?php echo $eventDate->format('d');	//Return the three-letter representation of Month. ?></span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
              <p><?php echo wp_trim_words(get_the_content(), 18);?> <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a></p>
            </div>
          </div>
  <?php
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
