//Ref: https://stackoverflow.com/questions/45650729/wp-json-api-returns-401-on-post-edit-with-react-and-nonce
/*
* I used Jquery-free code to follow Mr. Brad's course.
*
*/

import axios from "axios"

class MyNotes {
	constructor() {
		this.deleteButton = document.querySelectorAll(".delete-note");
		
		this.editButton = document.querySelectorAll(".edit-note");
		
		this.events();
	}
	
	events() {
	for (var i = 0; i < this.deleteButton.length; i++) {	//https://stackoverflow.com/questions/27946703/javascript-foreach-add-addeventlistener-on-all-buttons/27947429
	 this.deleteButton[i].addEventListener("click", (e) => {
	 	this.deleteNote(e)
	 })
	}
	
		for (var j = 0; j < this.deleteButton.length; j++) {	
	 this.editButton[j].addEventListener("click", (e) => {
	 	this.editNote(e)
	 })
	}
	}
	
	// Methods will go here
	
	async editNote(e) {
		var thisNote = e.target.parentElement;
		
		var temp = thisNote.querySelectorAll('.note-title-field, .note-body-field')
		for (var k=0; k< temp.length; k++) {
			temp[k].removeAttribute("readonly");
			temp[k].classList.add("note-active-field");
		}
		
		var temp1 = thisNote.querySelectorAll('.update-note');
		for (var s=0; s< temp1.length; s++) {
			temp1[s].classList.add("update-note--visible");
			
		}
		
	}
	
	async deleteNote(e) {
		var thisNote =  e.target.parentElement;
 
		const response = await axios.delete(`${universityData.root_url}/wp-json/wp/v2/note/${thisNote.getAttribute('data-id')}` ,
		  {headers:{'X-WP-Nonce': universityData.nonce}}) //Authorization here.
		.then((response) => {
			this.fadeOut(thisNote);
			console.log(response);
		})
		.catch(
			(errors) => {
			console.log("Sorry");
			console.log(errors);
			}
		)
 	}
 	
 	fadeOut(e) {
 	 e.classList.add("fade-out");
 	
 	}
}
export default MyNotes
