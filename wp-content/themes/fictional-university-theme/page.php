<?php //For single page.

	get_header();	
	
	while(have_posts()) {
	the_post(); ?>
	<!--interior-page.html line 39 to line 68.-->
	  <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title();/*title function*/?></h1>
        <div class="page-banner__intro">
          <p>DONT FORGET TO REPLACE ME LATER</p>
        </div>
      </div>
    </div>

    <div class="container container--narrow page-section">
    <?php
    	$theParent = wp_get_post_parent_id(get_the_ID());
    
    	if($theParent) //get the id of parent page of current page. If doesn't have, then it will be 0.
    	{?>
    		<!--crumbbox will be shown iff it is within a child page.-->
    	    <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent);?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent);//back to the parent page ?></a> <span class="metabox__main"><?php echo the_title(); /*the title for pages*/?></span>
        </p>
      </div>
    		
    	<?php }
    ?>
  

	<?php 
	$testArray = get_pages(array(
	 'child_of' => get_the_ID()
	
	)); //to test if the current page has any children.
	if ($theParent or $testArray) {?>
      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent) ?>"><?php echo get_the_title($theParent);?></a></h2>
        <ul class="min-list">
	<?php
	/*
	If at a parent page currently, we would list all of its children pages' titles.
	If at a children page currently, we would list all of its parent's children pages' titles.
	*/
	  if ($theParent) {
	  	$findChildrenOf = $theParent;
	  } else {
	  	$findChildrenOf = get_the_ID();
	  }
	
		wp_list_pages(array(
		 'title_li' => NULL,
		 'child_of' => $findChildrenOf,
		 'sort_column' => 'menu_order'
		));
	?>
        </ul>
      </div>
      <?php } ?>

      <div class="generic-content">
       <?php the_content(); ?>
      </div>
    </div>
	<?php }
	
	get_footer();
?>
