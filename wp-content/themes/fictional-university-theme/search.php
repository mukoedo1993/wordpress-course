<!--This file is used to power the URL'DOAMIN_NAME'/search-->
This is the generic blog listing screen template rendered by searchDOTphp.


<?php

get_header(); 
pageBanner(array(
  'title' => 'Search results',
  'subtitle' => 'You searched for &ldquo;'.esc_html(get_search_query(false)).'&rdquo;'
));
?>
	 
    
<div class="container container--narrow page-section">	<!--A container div that our blog posts can live in.-->
<?php 

  if (have_posts()) {
    while(have_posts()) {
    the_post(); 
    get_template_part('template-parts/content', get_post_type());

  }
  //pagination links
  echo paginate_links();
  } else {
  	echo '<h2 class="headline headline--small-plus">No results match that search.</h2>';
  }
  
  get_search_form();//This function will use ROOT/seachform.php 's content.

?>
</div>


<?php

get_footer();
?>
