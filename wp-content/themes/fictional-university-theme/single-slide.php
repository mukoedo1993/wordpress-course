singleDASHslideDOTPhp
<!--For single slide once user clicked the image in the main page. -->

<?php

get_header();

while(have_posts()) {
	the_post(); 
	pageBanner();
	
	$image = get_field('background_slide');
	$s_title = get_field('slide_subtitle');
	$s_subtitle = get_field('slide_title');
	
?>
<div class="hero-slider__slide" style="background-image: url(<?php echo $image['url'];?>)">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center"><?php echo $s_title; ?></h2>
                <p class="t-center"><?php echo $s_subtitle; ?></p>
                <p class="t-center no-margin"><a href="<?echo get_permalink(); ?>" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
            <?php the_content(); ?>
          </div>
<?php
}
?>
