single-program.php is used here to render this page.


<?php //After you click a post's permalink, you would view this page.
	
	get_header();	
	
	while(have_posts()) {
	the_post(); ?>
	<div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title();/*title function*/ ?></h1>
        <div class="page-banner__intro">
          <p>DONT FORGET TO REPLACE ME LATER</p>
        </div>
      </div>
    </div>
    
    
    <div class="container container--narrow page-section">
    	<div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program');  //get the archive link for this post type, here, event.?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs</a> <span class="metaxbox__main"><?php the_title();?> </span>
        </p>
      </div>
    	
    	<div class="generic-content"><?php the_content();?></div>
    	
    	
    	<?php
    	
    	 $relatedProfessors = new WP_Query(
		 array(
		   'posts_per_page' => -1, //pull back all associated professors
		    'post_type' => 'professor',
		    //'meta_key' is not needed to order by here
		    'orderby' => 'title', //orderby number
		    'order' => 'ASC',//'DESC' means descending, 'ASC' means ascending.
		    'meta_query' => array(
		      
		      //this array is set for sorting programs
		      array( //If the array of related_programs contains or like basically means contains the ID number of the current program post, 
		      //then that's what we're looking for.
		        'key' => 'related_programs',
		        'compare' => 'LIKE',
		        'value' => '"'.get_the_ID().'"'
		      )
		    )
		    
		 ));//negative one means all posts fitting this requirements.
		 
if ($relatedProfessors->have_posts()) { 
   echo '<hr class="section-break">';
   echo '<h2 class="headline headline--medium">' . get_the_title(). ' Professors</h2>';
	 
	 echo '<ul class="professor-cards">';
	 while ($relatedProfessors->have_posts()) {
	  $relatedProfessors->the_post();?>
		<li class="professor-card__list-item">
		 <a class="professor-card" href="<?php the_permalink(); ?>">
		  <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>">
		  <span class="professor-card__name"><?php the_title(); ?></span>
		 </a>
		</li>
	 <?php }
	 echo '</ul>';
			}
    	
    		wp_reset_postdata();
    	
		$today = date('Ymd');
		
		
		 $homepageEvents = new WP_Query(
		 array(
		   'posts_per_page' => 2, //if set as negative 1: all pages shown in one page
		    'post_type' => 'event',
		    'meta_key' => 'event_date' ,
		    'orderby' => 'meta_value_num', //orderby number
		    'order' => 'ASC',//'DESC' means descending, 'ASC' means ascending.
		    'meta_query' => array(
		    
		    //this array is set for sorting events so that we only show today or future's events.
		      array(
		      	'key' => 'event_date',//only today or future's
		      	'compare' => '>=',
		      	'value' => $today, //'Ymd' stands for today
		      	'type' => 'numeric'
		      ),
		      
		      //this array is set for sorting programs
		      array( //If the array of related_programs contains or like basically means contains the ID number of the current program post, 
		      //then that's what we're looking for.
		        'key' => 'related_programs',
		        'compare' => 'LIKE',
		        'value' => '"'.get_the_ID().'"'
		      )
		    )
		    
		 ));//negative one means all posts fitting this requirements.
		 
if ($homepageEvents->have_posts()) { 
   echo '<hr class="section-break">';
   echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title(). ' Events</h2>';
	 
	 while ($homepageEvents->have_posts()) {
	  $homepageEvents->the_post();?>
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
	<p> <?php if (has_excerpt()) {
	  echo get_the_excerpt(); //If we run the the_excerpt() function directly, WP will help us set some awkward vertical gaps.
	} else {
	echo wp_trim_words(get_the_content(), 18); //fallback if we doesn't have 
	} ?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
	</div>
	</div>
	 <?php }
			}
			?>
    
    </div>
	<hr><!--In real world, we use css to divide different parts.-->
	<?php }
	
	get_footer();
?>

