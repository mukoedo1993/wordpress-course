import $ from 'jquery';

class Like {
 constructor() {
 	this.events();
 }
 
 events() {
 	$(".like-box").on("click", this.ourClickDispatcher.bind(this));
 }
 
 // methods
 	ourClickDispatcher(e) {
 		var currentLikeBox = $(e.target).closest(".like-box");
 	
 		if (currentLikeBox.attr('data-exists') == 'yes') { //If you want to pull in fresh and up-to-dated data attributes.
 			this.deleteLike(currentLikeBox);
 		} else {
 			this.createLike(currentLikeBox);
 		}
 		
 	}
 	
 	createLike(currentLikeBox) {
 		$.ajax({
 		beforeSend: (xhr) => {
 		 xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
 		},
 		url: universityData.root_url + '/wp-json/university/v1/manageLike',
 		type: 'POST',
 		data: { 'professorId': currentLikeBox.data('professor')},
 		success: (response) => {
 			currentLikeBox.attr('data-exists', 'yes');
 			var likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10); //based on 10 converted to a string
 			likeCount++; 
 			currentLikeBox.find(".like-count").html(likeCount);
 			currentLikeBox.attr("data-like", response);
 			console.log(response);
 		},
 		error: (err) => {
 		 console.log(err);
 		}
 		});
 	}
 	
 	deleteLike(currentLikeBox) {
 		$.ajax({
 		beforeSend: (xhr) => {
 		 xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
 		},
 		url: universityData.root_url + '/wp-json/university/v1/manageLike',
 		type: 'DELETE',
 		data: {'like': currentLikeBox.attr('data-like')},	//we need to pass the id of like post here.
 		success: (response) => {
 			currentLikeBox.attr('data-exists', 'no');
 			var likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10); //based on 10 converted to a string
 			likeCount--; 
 			currentLikeBox.find(".like-count").html(likeCount);
 			currentLikeBox.attr("data-like", '');
 			console.log(response);
 		},
 		error: (err) => {
 		 console.log(err);
 		}
 		});
 	}
 
}

export default Like;
