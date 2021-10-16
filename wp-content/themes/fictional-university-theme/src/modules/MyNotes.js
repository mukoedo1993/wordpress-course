//Ref: https://stackoverflow.com/questions/45650729/wp-json-api-returns-401-on-post-edit-with-react-and-nonce
/*
* I used Jquery-free code to follow Mr. Brad's course.
*
*/

import axios from "axios"

class MyNotes {
	constructor() {
		this.deleteButtons = document.querySelectorAll(".delete-note");
		
		this.editButtons = document.querySelectorAll(".edit-note");
		
		this.updateButtons = document.querySelectorAll(".update-note");
		
		this.events();
	}
	
	events() {
	
	this.deleteButtons.forEach(e => { e.addEventListener("click", (el) => this.deleteNote(el));})
	
	this.editButtons.forEach(e => {e.addEventListener("click", (el) => this.editNote(el));})
	
	this.updateButtons.forEach(e => {e.addEventListener("click", (el) => this.updateNote(el));})
	
	}
	
	// Methods will go here
	
	async editNote(e) {
		const thisNote = e.target.parentElement;
		
		if (thisNote.hasAttribute("state") && thisNote.getAttribute("state") == "editable") {
			this.makeNoteReadOnly(thisNote);
		} else {
			this.makeNoteEditable(thisNote);
		}
	}
	
	async makeNoteEditable(thisNote) {
		const edit_note_icons_after_click = thisNote.querySelectorAll('.edit-note')
		edit_note_icons_after_click.forEach(e => e.innerHTML='<i class="fa fa-times" aria-hidden="true"></i> Cancel ')
		
		const fields_selected = thisNote.querySelectorAll('.note-title-field, .note-body-field')
		fields_selected.forEach(e => {
			e.removeAttribute("readonly");
			e.classList.add("note-active-field");
		})
		
		const update_note = thisNote.querySelectorAll('.update-note');
		update_note.forEach(e =>{ e.classList.add("update-note--visible");});
		
		thisNote.setAttribute("state", "editable");
	
	}
	
	async makeNoteReadOnly(thisNote) {
		const edit_note_icons_after_click = thisNote.querySelectorAll('.edit-note')
		edit_note_icons_after_click.forEach(e => e.innerHTML='<i class="fa fa-pencil" aria-hidden="true"></i> Edit ')
		
		const fields_selected = thisNote.querySelectorAll('.note-title-field, .note-body-field')
		fields_selected.forEach(e => {
			e.setAttribute("readonly", "readonly");
			e.classList.remove("note-active-field");
		})
		
		const update_note = thisNote.querySelectorAll('.update-note');
		update_note.forEach(e =>{ e.classList.remove("update-note--visible");});
		
		thisNote.setAttribute("state", "cancel");
	
	}
	
	async deleteNote(e) {
		const thisNote =  e.target.parentElement;
 
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
 	
	async updateNote(e) {
	const thisNote =  e.target.parentElement;
	
	const ourUpdatedPost = {
		title: thisNote.getElementsByClassName("note-title-field")[0].value,
		content: thisNote.getElementsByClassName("note-body-field")[0].value
	
	}
	console.log(ourUpdatedPost)

	const response = await axios.post(`${universityData.root_url}/wp-json/wp/v2/note/${thisNote.getAttribute('data-id')}` ,
	   	 ourUpdatedPost,	 	     
	     	 { 
	   	  headers:{'X-WP-Nonce': universityData.nonce}
	   	 }, //data as 2nd argument, headers(authorization) ad 3rd argument.
	   ) 
	.then((response) => {
		this.makeNoteReadOnly(thisNote);
		console.log(response);
		console.log("Congrats");
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
