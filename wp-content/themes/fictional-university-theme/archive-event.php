
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
    the_post(); ?>
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
              <p><?php echo wp_trim_words(get_the_content(), 18);?> <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a></p>
            </div>
          </div>
  <?php
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
