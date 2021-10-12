import $ from 'jquery' //to leverage jquery

class Search {
	
	// 1. describe and create/initiate our object
	constructor() {
	  this.addSearchHTML();
	
	  this.resultsDiv = $("#search-overlay__results");
	
	  this.openButton = $(".js-search-trigger");
	  this.closeButton = $(".search-overlay__close");
	  this.searchOverlay = $(".search-overlay");
	  this.searchField =  $(".search-term");
	  this.events();
	  this.isOverlayOpen = false;
	  
	  this.isSpinnerVisible = false;
	  
	  this.previousValue;
	  
	  this.typingTimer;
	}
	
	// 2. events
	events() {
	  this.openButton.on("click", this.openOverlay.bind(this));
	  this.closeButton.on("click", this.closeOverlay.bind(this));
	  
	  $(document).on("keydown", this.keyPressDispatcher.bind(this));
	  
	  this.searchField.on("keyup", this.typingLogic.bind(this));//If we don't bind this, then, contextually, typingLogic's this keyword will point to thisDOTsearchField. 
	}
	
	
	// 3. methods (function, action...)
	typingLogic() {
	 	if (this.searchField.val() != this.previousValue) {
		 	clearTimeout(this.typingTimer);
		 	
		 	if (this.searchField.val()) {
		         if (!this.isSpinnerVisible) {
			 	this.resultsDiv.html('<div class="spinner-loader"></div>');
			 	this.isSpinnerVisible = true;
	 	}
			this.typingTimer = setTimeout(this.getResults.bind(this), 750);
		 		
		 	} else {
		 	   this.resultsDiv.html('');
		 	   this.isSpinnerVisible = false;
		 	}
		 	
	 	}
	 	

		this.previousValue = this.searchField.val();
	}
	
	
	getResults() {
	//async:
		$.when($.getJSON/*Use Javascript to send out a request to the URL.*/(universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchField.val()),
		$.getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchField.val())
		).then((posts, pages) => {
				 var combinedResults = posts[0].concat(pages[0]); //posts array: first item is the actual JSON data; second item: whether succeeed or failed.
		   		  this.resultsDiv.html(`
		  	<h2 class="search-overlay__section-title">General Information</h2>
		  	
		  	${combinedResults.length ? '<ul class="link-list min-list">' : '<p>No general information matches that match.</p>'}
		  	  ${combinedResults.map(item => `<li><a href="${item.link}">${item.title.rendered}</a> ${item.type == 'post'? `by ${item.authorName}` : '' }</li>`).join('')}
		  	${combinedResults.length ? '</ul>' : ''}
		  `);
		  this.isSpinnerVisible = false;
		}, () => {
		  this.resultsDiv.html('<p>Unexpected error, please try again.</p>'); //error caught
		});
	}
	
	
	keyPressDispatcher(e) {
	  
	
	  if (e.keyCode == 83 && !this.isOverlayOpen && !$("input, textarea").is(':focus')) { //If any field is currently focus, this will be valuated as false
	    this.openOverlay();
	  }
	  
	  if (e.keyCode == 27 && this.isOverlayOpen) {
	    this.closeOverlay();
	  }
	}
	
	 openOverlay() {
	   this.searchOverlay.addClass("search-overlay--active");
	   $("body").addClass("body-no-scroll");
	   
	   this.searchField.val('');
	  
	   setTimeout( () =>  this.searchField.focus() /*To autofocus the search field once we open the search layout.*/,301);
	  
	   console.log("Our open method just ran!");
	   this.isOverlayOpen = true;
	}
	
	closeOverlay() {
	  this.searchOverlay.removeClass("search-overlay--active");
	  $("body").removeClass("body-no-scroll");
	  console.log("Our close method just ran!");
	  this.isOverlayOpen = false;
	}
	
	addSearchHTML() {
	  $("body").append(`
	      <div class="search-overlay">
      <div class="search-overlay__top">
       <div class="container">
         <i class="fa fa-search search-overlay__icon" aria-hidden="true"> </i>
         <input type="text" class="search-term" placeholder="What are you looking for?"
          id="search-term" autocomplete="off">
          <i class="fa fa-window-close search-overlay__close" aria-hidden="true"> </i>
       </div>
      </div>
      
      <div class="container">
       <div id="search-overlay__results"></div>
      </div>
    </div>
	  `);
	}

}

export default Search
