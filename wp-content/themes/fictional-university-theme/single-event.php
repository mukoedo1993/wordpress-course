<!--for single event post. -->
singleSLASHeventDOTphp
<?php //After you click a post's permalink, you would view this page.
	
	get_header();	
	
	while(have_posts()) {
	the_post();
	
	pageBanner(); //Notice that we don't need any arguments here.
	 ?>

    
    
    <div class="container container--narrow page-section">
    	<div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event');  //get the archive link for this post type, here, event.?>"><i class="fa fa-home" aria-hidden="true"></i> Events Home</a> <span class="metaxbox__main"><?php the_title();?> </span>
        </p>
      </div>
    	
    	<div class="generic-content"><?php the_content();?></div>
    
    	<?php
    		
    		
    		$relatedPrograms = get_field('related_programs'); //get an array of related_programs
    		if ($relatedPrograms) { //if the relatedPrograms is blank, it will be valuated as false.
    		echo '<hr class="section-break">';
    		echo '<h2 class="headline headline--medium">Related Program(s)</h2>';
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
