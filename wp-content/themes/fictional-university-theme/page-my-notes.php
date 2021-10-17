pageDASHmyDASHnotesDOTPhp
<?php //For single page.
	
	if (!is_user_logged_in()) {
		wp_redirect(esc_url(site_url('/')));
		exit; //Once wp_redirect is completed, this file will stop running and will not use server's resource anymore.
	}

	get_header();	
	
	while(have_posts()) {
	the_post(); 
	pageBanner(
	//array(
	  //'title' => 'Hello there this is the title',
	 // 'photo' => 'https://upload.wikimedia.org/wikipedia/commons/4/44/Flag_of_the_Second_East_Turkestan_Republic.svg'
	//)
	);?>
	<!--interior-page.html line 39 to line 68.-->
	 

    <div class="container container--narrow page-section">
    
    	<div class="create-note">
    		<h2 class="headline headline--medium">Create New Note</h2>
    		<input class="new-note-title" placeholder="title">
    		<textarea class="new-note-body" placeholder="Your note here."> </textarea>
    		<span class="submit-note"> Create Note </span>
    		
    	</div>
    
  	<ul class="min-list link-list" id="my-notes">
  	  <?php
  	   $userNotes = new WP_Query(array(
  	   	'post_type' => 'note',
  	   	'posts_per_page' => -1,
  	   	'author' => get_current_user_id()
  	   ));
  	   
  	   while($userNotes->have_posts()) {
  	   	$userNotes->the_post();?>
  	   	<li data-id="<?php the_ID();	//So that Javascript could access to the ID you click on.?>">
				 
  	   		<input readonly class="note-title-field" value="<?php echo str_replace( 'Private: ' , '', esc_attr(get_the_title())); 
					 //replace the 1st argument within 3rd argument with 2nd argument.?>">
  	   		<span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit </span>
  	   		<span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </span>
  	   		<textarea readonly class="note-body-field"><?php echo esc_textarea(wp_strip_all_tags(get_the_content()));?></textarea>
  	   		<span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save </span>
  	   	</li>
  	   	<?php
  	   	
  	   }
  	   
  	  ?>
  	</ul>
    </div>
	<?php }
	
	get_footer();
?>
