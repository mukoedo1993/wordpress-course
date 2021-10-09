archive-program.php


<?php

get_header(); 
pageBanner(array(
  'title' => 'All Programs',
  'subtitle' => 'There is sth for everyone. Have a look around.'
));
?>
 
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
