archive-program.php


<?php

get_header(); ?>
	  <div class="page-banner"> <!--banner-->
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">All Programs</h1>
        <div class="page-banner__intro">
          <p>There is sth for everyone. Have a look around.</p>
        </div>
      </div>
    </div>
    
 
<div class="container container--narrow page-section">	<!--A container div that our blog posts can live in.-->

<ul class="link-list min-list">
<?php 
  while(have_posts()) { //Here, we just want to display title for each program.
    the_post(); ?>
       <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
  <?php
  }
  //pagination links
  echo paginate_links();

?>
</ul>



</div>


<?php

get_footer();
?>
