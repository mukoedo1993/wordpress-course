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
        <a href="#" class="btn btn--large btn--blue">Find Your Major</a>
      </div>
    </div>

    <div class="full-width-split group">
      <div class="full-width-split__one">
        <div class="full-width-split__inner">
          <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>
		<?php
		$today = date('Ymd');
		
		 $homepageEvents = new WP_Query(array(
		   'posts_per_page' => -1,
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
		  $homepageEvents->the_post();?>
		            <div class="event-summary">
            <a class="event-summary__date t-center" href="#">
              <span class="event-summary__month"><?php 
               $eventDate = new DateTime(get_field('event_date')); //DateTime's ctor takes the date of event_date custom field.
               echo $eventDate->format('M');	//Return the three-letter representation of Month.
               ?></span>
              <span class="event-summary__day"><?php echo $eventDate->format('d');	//Return the three-letter representation of Month. ?></span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
              <p> <?php if (has_excerpt()) {
                  echo get_the_excerpt(); //If we run the the_excerpt() function directly, WP will help us set some awkward vertical gaps.
              } else {
              	echo wp_trim_words(get_the_content(), 18); //fallback if we doesn't have 
              } ?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
            </div>
          </div>
		 <?php }
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
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/bus.jpg')// This wordpress function will generate the path to our theme folder all on its own. ?>)">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">Free Transportation</h2>
                <p class="t-center">All students have free unlimited bus fare.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/apples.jpg')// This wordpress function will generate the path to our theme folder all on its own. ?>)">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">An Apple a Day</h2>
                <p class="t-center">Our dentistry program recommends eating apples.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/bread.jpg')?>)">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">Free Food</h2>
                <p class="t-center">Fictional University offers lunch plans for those in need.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
        </div>
        <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
      </div>
    </div>

<?php	
	get_footer();
?>
