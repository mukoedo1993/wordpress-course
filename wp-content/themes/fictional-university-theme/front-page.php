<!--It will be our real homepage since 21st course.-->
<?php get_header(); ?>

<?php 
//To echo or not to echo:
/*
rule of thumb:

If a wordpress begins with the word get, it will not going to echo anything for you.

On the other hand, if a function begins with the word the , that means wordpress will indeed handle echoing and outputting it onto the page for you.
*/
 ?>

   <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/library-hero.jpg')// This wordpress function will generate the path to our theme folder all on its own. ?>)"></div>
      <div class="page-banner__content container t-center c-white">
        <h1 class="headline headline--large">Welcome!</h1>
        <h2 class="headline headline--medium">We think you&rsquo;ll like it here.</h2>
        <h3 class="headline headline--small">Why don&rsquo;t you check out the <strong>major</strong> you&rsquo;re interested in?</h3>
        <a href="<?php echo get_post_type_archive_link('program'); ?>" class="btn btn--large btn--blue">Find Your Major</a>
      </div>
    </div>

    <div class="full-width-split group">
      <div class="full-width-split__one">
        <div class="full-width-split__inner">
          <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>
		<?php
		$today = date('Ymd');
		
		 $homepageEvents = new WP_Query(array(
		   'posts_per_page' => 2, //if set as negative 1: all pages shown in one page
		    'post_type' => 'event',
		    'meta_key' => 'event_date' ,
		    'orderby' => 'meta_value_num', //orderby number
		    'order' => 'ASC',//'DESC' means descending, 'ASC' means ascending.
		    'meta_query' => array(
		      array(
		      	'key' => 'event_date',//only today or future's
		      	'compare' => '>=',
		      	'value' => $today, //'Ymd' stands for today
		      	'type' => 'numeric'
		      )
		    )
		    
		 ));//negative one means all posts fitting this requirements.
		 
		 while ($homepageEvents->have_posts()) {
		  $homepageEvents->the_post();
		  
		  get_template_part('template-parts/content', 'event'); //first argument: point to the event file; second argument (OPTIONAL): add dash and this argument to the first argument to locate the file.
		  
		  }
		?>


          <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link('event'); //get the event's posts' archive link. ?>" class="btn btn--blue">View All Events</a></p>
        </div>
      </div>
      <div class="full-width-split__two">
        <div class="full-width-split__inner">
          <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>
	   
	   <?php
	     $homepagePosts = new WP_Query(array(
	       'posts_per_page' => 2,
	      // 'category_name' => 'awards' // ... and whose category name is exactly 'awards'.
	     
	     )); //To see the title of two most recent blog posts ...
	     
	   
	     while ($homepagePosts->have_posts()) {
	      $homepagePosts->the_post(); ?>

	   <!--while loop through the posts.-->

          <div class="event-summary">
            <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
              <span class="event-summary__month"><?php the_time('M'); ?></span>
              <span class="event-summary__day"><?php the_time('d'); ?></span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
              <p><?php if (has_excerpt()) {
                  echo get_the_excerpt(); //If we run the the_excerpt() function directly, WP will help us set some awkward vertical gaps.
              } else {
              	echo wp_trim_words(get_the_content(), 18); //fallback if we doesn't have 
              } ?> <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a></p>
            </div>
          </div>
	<?php } wp_reset_postdata();
	   ?>


          <p class="t-center no-margin"><a href="<?php echo site_url('/blog');//to the blog page?>" class="btn btn--yellow">View All Blog Posts</a></p>
        </div>
      </div>
    </div>

    <div class="hero-slider">
     <div data-glide-el="track" class="glide__track">
      <div class="glide__slides">
     <?php //
     	$slides = new WP_Query(
		 array(
		   'posts_per_page' => -1, 
		    'post_type' => 'slide',
		  
		    'orderby' => 'title', //orderby number
		    'order' => 'ASC',//'DESC' means descending, 'ASC' means ascending.    
		 ));
		 
		
		 
	while($slides->have_posts()){
		$slides->the_post();
		
		$image = get_field('background_slide');
		$s_title = get_field('slide_subtitle');
		$s_subtitle = get_field('slide_title');
		    if( !empty($image) )	//To set the image to be displayed properly
		?>
		
	<div class="hero-slider__slide" style="background-image: url(<?php echo $image['url'];?>)">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center"><?php echo $s_title; ?></h2>
                <p class="t-center"><?php echo $s_subtitle; ?></p>
                <p class="t-center no-margin"><a href="<?echo get_permalink(); ?>" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
		<?php
		
	}
     ?>
      </div>
       <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
      </div>
     </div>
    </div>

<?php	
    
	get_footer();
?>
