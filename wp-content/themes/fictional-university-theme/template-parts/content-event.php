  contentDASHevent
  <?php echo 'contentDASHevent';?>
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
