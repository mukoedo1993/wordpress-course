<!--This file is used to power the URL'DOAMIN_NAME'/blog-->
This is the generic blog listing screen template rendered by indexDOTphp.


<?php

get_header(); 
pageBanner(array(
  'title' => 'Welcome to our blog!',
  'subtitle' => 'Keep up with our latest news!'
));
?>
	 
    
<div class="container container--narrow page-section">	<!--A container div that our blog posts can live in.-->
<?php 
  while(have_posts()) {
    the_post(); ?>
    <div class="post-item">
    	<h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
    	
    	<div class="metabox">  
    	 <p>Posted by <?php the_author_posts_link();//the link to all posts of the current author?> on <?php the_time('n.j.y');?> in <?php echo get_the_category_list(',');/*comma stands for the separating char here.*/?></p>
    	</div>
    	
    	<div class="generic-content">
    	 <?php the_excerpt(); //OR// the_content(); ?> 
    	 <p><a class="btn btn--blue" href="<?php the_permalink();//To the permalink of this post.?>">Continue reading &raquo;</a></p>
    	</div>
    </div>
  <?php
  }
  //pagination links
  echo paginate_links();

?>
</div>


<?php

get_footer();
?>
