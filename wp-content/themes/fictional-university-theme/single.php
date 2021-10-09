SINGLE_PHP_HERE!
<?php //After you click a post's permalink, you would view this page. For and ONLY for pure individual post's link. Any other kind of individual post is not rendered here.
	
	get_header();	
	
	while(have_posts()) {
	the_post(); 
	pageBanner();
	?>
	
    
    
    <div class="container container--narrow page-section">
    	<div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); //this argument ensures that the URL we generate here is absolute rather than relative.?>"><i class="fa fa-home" aria-hidden="true"></i> Blog Home</a> <span class="metaxbox__main">Posted by <?php the_author_posts_link(); //the link to all posts of the current author?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', ');/*comma stands for the separating char here.*/ ?>&nbsp; </span>
        </p>
      </div>
    	
    	<div class="generic-content"><?php the_content();?></div>
    
    </div>
	<hr><!--In real world, we use css to divide different parts.-->
	<?php }
	
	get_footer();
?>
