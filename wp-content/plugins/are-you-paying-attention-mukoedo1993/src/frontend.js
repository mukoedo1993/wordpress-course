import React from 'react'
import ReactDOM from 'react-dom'

import "./frontend.scss"
//frontend of our block
const divsToUpdate = document.querySelectorAll(".paying-attention-update-me")

divsToUpdate.forEach(function(div)/* for each block */ {
	ReactDOM.render(<Quiz />, div)
	div.classList.remove("paying-attention-update-me")
})


function Quiz() {
	return (
	 <div className="paying-attention-frontend">
	   Hello from React
	 </div>
	)
}
