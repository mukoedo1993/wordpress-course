//Ref: https://stackoverflow.com/questions/45650729/wp-json-api-returns-401-on-post-edit-with-react-and-nonce
/*
 * I used Jquery-free code to follow Mr. Brad's course.
 * 
 */

import axios from "axios"

class MyNotes {
  constructor() {
    this.title_temp = ""

    this.content_temp = ""

    this.allMyNotes = document.querySelectorAll("#my-notes")

    //this.deleteButtons = document.querySelectorAll(".delete-note")

    //this.editButtons = document.querySelectorAll(".edit-note")

    //this.updateButtons = document.querySelectorAll(".update-note")

    this.submitButton = document.querySelectorAll(".submit-note")

    this.events()
  }

  events() {
    console.log(this.allMyNotes)
    this.allMyNotes.forEach((e) => {
      e.addEventListener("click", (el) => {
        if (this.hasClass(el.target, "delete-note")) {
          this.deleteNote(el)
        }
      })
    })

    this.allMyNotes.forEach((e) => {
      e.addEventListener("click", (el) => {
        if (this.hasClass(el.target, "edit-note")) {
          this.editNote(el)
        }
      })
    })

    this.allMyNotes.forEach((e) => {
      e.addEventListener("click", (el) => {
        if (this.hasClass(el.target, "update-note")) {
          this.updateNote(el)
        }
      })
    })

    this.submitButton.forEach((e) => e.addEventListener("click", (el) => this.submitNote(el)))
  }

  // Methods will go here

  async editNote(e) {
    const thisNote = e.target.parentElement

    if (thisNote.hasAttribute("state") && thisNote.getAttribute("state") == "editable") {
      this.makeNoteReadOnly(thisNote)

      //If user stop editing, we want the value of title and content to be reverted to the original values.
      thisNote.getElementsByClassName("note-title-field")[0].value = this.title_temp
      thisNote.getElementsByClassName("note-body-field")[0].value = this.content_temp

      this.title_temp = ""
      this.content_temp = ""
    } else {
      this.makeNoteEditable(thisNote)
      this.title_temp = thisNote.getElementsByClassName("note-title-field")[0].value
      this.content_temp = thisNote.getElementsByClassName("note-body-field")[0].value
    }
  }

  async makeNoteEditable(thisNote) {
    const edit_note_icons_after_click = thisNote.querySelectorAll(".edit-note")
    edit_note_icons_after_click.forEach((e) => (e.innerHTML = '<i class="fa fa-times" aria-hidden="true"></i> Cancel '))

    const fields_selected = thisNote.querySelectorAll(".note-title-field, .note-body-field")
    fields_selected.forEach((e) => {
      e.removeAttribute("readonly")
      e.classList.add("note-active-field")
    })

    const update_note = thisNote.querySelectorAll(".update-note")
    update_note.forEach((e) => {
      e.classList.add("update-note--visible")
    })

    thisNote.setAttribute("state", "editable")
  }

  async makeNoteReadOnly(thisNote) {
    const edit_note_icons_after_click = thisNote.querySelectorAll(".edit-note")
    edit_note_icons_after_click.forEach((e) => (e.innerHTML = '<i class="fa fa-pencil" aria-hidden="true"></i> Edit '))

    const fields_selected = thisNote.querySelectorAll(".note-title-field, .note-body-field")
    fields_selected.forEach((e) => {
      e.setAttribute("readonly", "readonly")
      e.classList.remove("note-active-field")
    })

    const update_note = thisNote.querySelectorAll(".update-note")
    update_note.forEach((e) => {
      e.classList.remove("update-note--visible")
    })

    thisNote.setAttribute("state", "cancel")
  }

  async deleteNote(e) {
    const thisNote = this.findNearestParentLi(e.target); //Corner case: the icon near the delay atucally belongs to different elements. However their common 

    const response = await axios
      .delete(`${universityData.root_url}/wp-json/wp/v2/note/${thisNote.getAttribute("data-id")}`, { headers: { "X-WP-Nonce": universityData.nonce } }) //Authorization here.
      .then((response) => {
        
        console.log(response);
        
        setTimeout(function () {
        	thisNote.classList.add("fade-out");
        }, 20);
        
        setTimeout(function () {
        	thisNote.remove();
        }, 401);
         if (response.data.userNoteCount < 5) {
         const toDisableActiveClassHere = document.querySelectorAll('.note-limit-message');
         toDisableActiveClassHere.forEach(el => {
         	el.classList.remove("active");
         });
        } 
        
      })
      .catch((errors) => {
        console.log("Sorry")
        console.log(errors)
      })
  }

  async updateNote(e) {
    const thisNote = e.target.parentElement

    const ourUpdatedPost = {
      title: thisNote.getElementsByClassName("note-title-field")[0].value,
      content: thisNote.getElementsByClassName("note-body-field")[0].value,
    }
    console.log(ourUpdatedPost)

    await axios
      .post(
        `${universityData.root_url}/wp-json/wp/v2/note/${thisNote.getAttribute("data-id")}`,
        ourUpdatedPost,
        {
          headers: { "X-WP-Nonce": universityData.nonce },
        } //data as 2nd argument, headers(authorization) ad 3rd argument.
      )
      .then((response) => {
        this.makeNoteReadOnly(thisNote)
        console.log(response)
        console.log("Congrats")
      })
      .catch((errors) => {
        console.log("Sorry")
        console.log(errors)
      })
  }

  async submitNote(e) {
    const ourNewPost = {
      title: document.getElementsByClassName("new-note-title")[0].value,
      content: document.getElementsByClassName("new-note-body")[0].value,
      status: "publish", //not vis
    }
    console.log(ourNewPost)

    await axios
      .post(
        `${universityData.root_url}/wp-json/wp/v2/note/`, //We don't need a specified id here.
        ourNewPost,
        {
          headers: { "X-WP-Nonce": universityData.nonce },
        } //data as 2nd argument, headers(authorization) ad 3rd argument.
      )
      .then((response) => {
        console.log(response)
        
        if(response.data == 'You have reached your note limits') {
         const toEnableActiveClassHere = document.querySelectorAll('.note-limit-message');
         toEnableActiveClassHere.forEach(el => {
         	el.classList.add("active");
         });
        }
        
        else{
        const newTitleAndBody = document.querySelectorAll(".new-note-title, .new-note-body")
        newTitleAndBody.forEach((el) => (el.value = ""))
        const my_notes = document.getElementById("my-notes")

        my_notes.insertAdjacentHTML(
          "afterbegin",
          `<li data-id="${response.data.id}" class="fade-in-calc">
  	   		<input readonly class="note-title-field" value="${response.data.title.raw}">
  	   		<span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit </span>
  	   		<span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </span>
  	   		<textarea readonly class="note-body-field">${response.data.content.raw}</textarea>
  	   		<span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save </span>
  	   	</li>`
        )
        
        // notice in the above HTML for the new <li> I gave it a class of fade-in-cal which will make it invisible temporaily sowe can count its natural height
        
        let finalHeight; // browser needs a specific height to transition to, you can't transition to 'auto' height
	let newlyCreated = document.querySelector("#my-notes li");
        
        // give the browser 30 ms to have the invisible element added to the DOM before moving on
        setTimeout(function () {
        	finalHeight = `${newlyCreated.offsetHeight}px`;
        	newlyCreated.style.height = "0px"
        }, 30);
        
        setTimeout(function () {
        	newlyCreated.classList.remove("fade-in-calc");
        	newlyCreated.style.height = finalHeight
        }, 50);
        
        // wait the duration of the CSS transition before removing the hardcoded calculated height
        //from the element so that our design is responsive once again
        setTimeout(function () {
        	newlyCreated.style.removeProperty("height")
        }, 450);
      }})
      .catch((errors) => {
      	
        console.log("Sorry")
        console.log(errors)
      })
  }

  fadeOut(e) {
    e.classList.add("fade-out")
  }

  hasClass(elem, className) {
    //src: https://stackoverflow.com/questions/203198/event-binding-on-dynamically-created-elements
    //helper function
    return elem.className.split(" ").indexOf(className) > -1
  }
  
   findNearestParentLi(el) {
   	//src: Brad Schiff
   	//To use the list here.
    let thisNote = el
    while (thisNote.tagName != "LI") {
      thisNote = thisNote.parentElement
    }
    return thisNote
  }
}
export default MyNotes
