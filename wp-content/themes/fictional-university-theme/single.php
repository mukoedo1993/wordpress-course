<?php //After you click a post's permalink, you would view this page.
	while(have_posts()) {
	the_post(); ?>
	<h2><?php the_title();?></h2>
	<?php the_content();?>
	<hr><!--In real world, we use css to divide different parts.-->
	<?php }
?>
