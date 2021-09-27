<?php get_header(); 

//depending on the current URL, wordpress will be look out for diffrernt file names in our theme folder.
//wordpress will look for file named single.php if we click the the_permalink(). If it doesn't exist, it will
//use index.php as a universal fallback.
	while(have_posts()) {
	the_post(); ?>
	<h2><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
	<?php the_content();?>
	<hr><!--In real world, we use css to divide different parts.-->
	<?php }
	
	
	get_footer();
?>
