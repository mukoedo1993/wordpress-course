//Ref: https://stackoverflow.com/questions/45650729/wp-json-api-returns-401-on-post-edit-with-react-and-nonce
/*
* I used Jquery-free code to follow Mr. Brad's course.
*
*/

import axios from "axios"

class MyNotes {
	constructor() {
		this.deleteButton = document.querySelector(".delete-note");
		
		this.events();
	}
	
	events() {
	 this.deleteButton.addEventListener("click", () => {
	 	this.deleteNote();
	 });
	
	}
	
	// Methods will go here
	async deleteNote() {
		const response = await axios.delete(universityData.root_url + '/wp-json/wp/v2/note/116' ,
		  {headers:{'X-WP-Nonce': universityData.nonce}}) //Authorization here.
		.then((response) => {
			console.log("Congrats");
			console.log(response);
		})
		.catch(
			(errors) => {
			console.log("Sorry");
			console.log(errors);
			}
		)
 	}
}
export default MyNotes
