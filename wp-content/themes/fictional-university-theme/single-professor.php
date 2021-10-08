<!--for single professor post-->
single-professor.php


<?php //After you click a post's permalink, you would view this page.
	
	get_header();	
	
	while(have_posts()) {
	the_post(); ?>
	<div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php $pageBannerImage = get_field('page_banner_background_image'); echo $pageBannerImage['sizes']['pageBanner'];/*https://www.advancedcustomfields.com/resources/image/*/ ?>)"></div>
      <div class="page-banner__content container container--narrow">
      <?php //print_r($pageBannerImage);?>
        <h1 class="page-banner__title"><?php the_title();/*title function*/?></h1>
        <div class="page-banner__intro">
          <p><?php the_field('page_banner_subtitle'); ?></p>
        </div>
      </div>
    </div>
    
    
    <div class="container container--narrow page-section">
    	
    	<div class="generic-content">
	    	<div class="row group">
	    	<!--1:2 layout-->
		    	<div class="one-third">
		    	  <?php the_post_thumbnail('professorPortrait'); //nickname of our image size is?>
		    	</div>
		    	
		    	<div class="two-thirds">
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

