# Quick Note About The Next Lesson
In the next lesson, while the code I show on screen is correct,<br>
I’ve noticed that a very common typo while following along with the video is to type `wp-rest` instead of the desired `wp_rest`

So just be sure to use a underscore and not a dash, while we’re writing the following code in our functions.php file in the next video: `'nonce' => wp_create_nonce('wp_rest')`

Also, in order to have the slide down and slide up animations of our notes run smoothly,<br> you’ll need to comment-out a bit of CSS code.<br> 
The file you’re looking for is in our theme folder in the `css/modules` sub-folder and is named `my-notes.css`.

Around line #131 of this file you’ll see a comment that reads `Reveal and Hide Fade Transitions`

I want you to comment out this block of code instead of deleting it entirely because later in the course<br> 
when we setup a jQuery-free version of `#My-Notes` we will want this CSS.
<br>However, for now, since we’re using jQuery, we want to remove this CSS so jQuery animations runs smoothly. To comment this section out, 
<br>you can type `/*` on a new line right above the #my-notes line, and then type `*/` on a new line at the very bottom of the file. This way you can simply remove these comments a bit later in the course when we want this code again.
