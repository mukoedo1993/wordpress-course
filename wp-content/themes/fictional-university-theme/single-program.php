single-program.php is used here to render this page.


<?php //After you click a post's permalink, you would view this page.
	
	get_header();	
	
	while(have_posts()) {
	the_post(); 
	pageBanner();
	?>

    
    
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
	  $homepageEvents->the_post();

	  get_template_part('template-parts/content-event');
	  }
   }
			?>
    
    </div>
	<hr><!--In real world, we use css to divide different parts.-->
	<?php }
	
	get_footer();
?>

