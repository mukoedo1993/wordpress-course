
<?php //http://fictionaluniversity.local/events/?>
dsdjdsksk

<!--from individual post's page's link to author's link. Also see: 
https://codex.wordpress.org/Creating_an_Archive_Index
 -->
hello world


<!--This file is used to power the URL'DOAMIN_NAME'/blog-->
This is the generic blog listing screen template. archive-event.php


<?php

get_header(); 
pageBanner(array(
  'title' => 'All Events',
  'subtitle' => 'Say what is going on in the world'
));
?>

    
<div class="container container--narrow page-section">	<!--A container div that our blog posts can live in.-->
<?php 
  while(have_posts()) {
    the_post(); 
    get_template_part('template-parts/content-event');
 
  }
  //pagination links
  echo paginate_links();

?>

<hr class="section-break">

<p>Looking for a recap of past events? <a href="<?php echo site_url('/past-events');//the link to the past event.?>">Check out past events archive</a>.</p>
</div>


<?php

get_footer();
?>
