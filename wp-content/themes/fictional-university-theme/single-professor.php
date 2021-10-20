<!--for single professor post-->
single-professor.php


<?php //After you click a post's permalink, you would view this page.
	
	get_header();	
	
	while(have_posts()) {
	the_post(); 
	pageBanner();
	?>
	
    
    
    <div class="container container--narrow page-section">
    	
    	<div class="generic-content">
	    	<div class="row group">
	    	<!--1:2 layout-->
		    	<div class="one-third">
		    	  <?php the_post_thumbnail('professorPortrait'); //nickname of our image size is?>
		    	</div>
		    	
		    	<div class="two-thirds">
		    		<?php 
		    		
		    		$likeCount = new WP_Query(array(
		    		  'post_type' => 'like',
		    		  'meta_query' => array(
		    		  	array(
		    		  	 'key' => 'liked_professor_id',
		    		  	 'compare' => '=',
		    		  	 'value' => get_the_ID()
		    		  	)
		    		  )	//We need it because we only want to pull in like posts, where the like professor ID
		    		  			//value matches the ID of the current professor page you are viewing. 
		    		));
		    		
		    		$existStatus = 'no';
		    		
		    		if (is_user_logged_in() ) {
		    		 $existQuery = new WP_Query(array(
		    		  'author' => get_current_user_id(), 
		    		  'post_type' => 'like',
		    		  'meta_query' => array(
		    		  	array(
		    		  	 'key' => 'liked_professor_id',
		    		  	 'compare' => '=',
		    		  	 'value' => get_the_ID()
		    		  	)
		    		  )	//We need it because we only want to pull in like posts, where the like professor ID
		    		  			//value matches the ID of the current professor page you are viewing. 
		    		));
		    		
		    		if ($existQuery->found_posts) {
		    		   $existStatus = 'yes';
		    		}
		    	}
		    		

		    		?>
		    		
		    		
		    	  <span class="like-box" data-professor="<?php the_ID(); ?>" data-exists="<?php echo $existStatus; ?>">
		    	  	<i class="fa fa-heart-o" aria-hidden="true"></i>
		    	  	<i class="fa fa-heart" aria-hidden="true"></i>
		    	  	<span class="like-count"><?php echo $likeCount->found_posts; //absolute total number of posts match the query. ?></span>
		    	  </span>
		    	  <?php the_content(); ?>
		    	</div>
	    	</div>
    	</div>
    
    	<?php
    		
    		
    		$relatedPrograms = get_field('related_programs'); //get an array of related_programs
    		if ($relatedPrograms) { //if the relatedPrograms is blank, it will be valuated as false.
    		echo '<hr class="section-break">';
    		echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';
    		echo '<ul class="link-list min-list">';
    		foreach($relatedPrograms as $program) {	?>
    		 <li><a href="<?php echo get_the_permalink($program);//post object here. ?>"><?php echo get_the_title($program);?></a></li>
    		<?php }
    	
    		echo '</ul>';
    		
    		}

    	?>
    </div>
	<hr><!--In real world, we use css to divide different parts.-->
	<?php }
	
	get_footer();
?>

