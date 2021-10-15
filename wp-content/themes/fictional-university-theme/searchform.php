       	<form class="search-form" method="get" action="<?php echo esc_url(site_url('/'));?>"> <!--action could control the URL we send to.-->
       		<label class="headline headline--medium" for="s">Peform a New Search: </label>
       		<div class="search-form-row">
       		 <input placeholder="What are you looking for?" class="s" id="s" type="search" name="s"> <!--for id match.-->
       		 <input class="search-submit" type="submit" value="Search">
       		</div>
       	</form>
