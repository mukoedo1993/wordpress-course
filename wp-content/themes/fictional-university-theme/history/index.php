<?php /*course 7th note:*/?>
<?php
  function greet($name, $color){
    echo "<p>Hi, my name is $name and my favorite color is $color.</p>";
  }
  greet('John', 'blue');
  greet('Jane', 'green');
?>


<h1><?php #blogInfo function gives us all of information about our website.
# https://developer.wordpress.org/reference/functions/bloginfo/
 bloginfo('name'); ?></h1>

 <p><?php
 bloginfo('description');
 ?></p>