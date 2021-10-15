   contentDASHpost
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
