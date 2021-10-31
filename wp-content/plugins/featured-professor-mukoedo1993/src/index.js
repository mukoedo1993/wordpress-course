import "./index.scss"
import { useSelect } from "@wordpress/data"

import { useState, useEffect } from "react"
import apiFetch from "@wordpress/api-fetch"

console.log(useSelect)
console.log("nimasile")

wp.blocks.registerBlockType("ourplugin/featured-professor", {	// corresponding to register_block_type(...) in featured-professor.php
  title: "Professor Callout",
  description: "Include a short description and link to a professor of your choice",
  icon: "welcome-learn-more",
  category: "common",
  attributes: {
    profId: { type: "string" }, //Argument: even though
    //profId should be number, but consider how WP actually loads data at the database
    // and just for general comparison <--- use string as a type here.
  },
  edit: EditComponent,
  save: function () {
    return null
  },
})

function EditComponent(props) {
  const [thePreview, setThePreview] = useState("")

  useEffect(() => {
	if (props.attributes.profId) {	//If profId is undefined, preview should be blank.
		updateTheMeta()
	  	async function go() {
	  	  const response = await apiFetch({
	  	  	path: `/featuredProfessor/v1/getHTML?profId=${props.attributes.profId}`,
	  	  	method: "GET"
	  	  })
	  	  setThePreview(response)
	  	}
	  	go()
	}
  }, [props.attributes.profId])
  
  useEffect(() => {
  	return () => {
  		updateTheMeta()
  	}//React will call it when this block gets deleted or unmounted.
  }, []) //empty array
  
  function updateTheMeta() {
  	const profsForMeta = wp.data.select("core/block-editor")
  	 .getBlocks()
  	 .filter(x => x.name == "ourplugin/featured-professor")
  	 .map(x => x.attributes.profId)
  		//select all block types in the edit screen. Return an array of all of our blocks.
  		//convert a complex array to simple ID numbers.
  	 .filter((x, index, arr) => {
  	  return arr.indexOf(x) == index	//If the index is the first instance of the values
  	 })
  	 console.log(profsForMeta)
  	wp.data.dispatch("core/editor").editPost({meta: {featuredprofessor: profsForMeta}})
  
  }
  
  const allProfs = useSelect((select) => {
    return select("core").getEntityRecords("postType", "professor", { per_page: -1 })
  })

  console.log(allProfs)

  if (allProfs == undefined) return <p>Loading...</p> //for waiting for loading
  //async: so, if still not loaded, allProfs will be undefined here. But as soon as our code
  // loaded, our code will be rendered.

  return (
    <div className="featured-professor-wrapper">
      <div className="professor-select-container">
        <select onChange={(e) => props.setAttributes({ profId: e.target.value })}>
          <option value="">Select a professor</option>
          {allProfs.map((prof) => {
            return (
              <option value={prof.id} selected={props.attributes.profId == prof.id}>
                {prof.title.rendered}
              </option>
            )
          })}
        </select>
      </div>
      <div dangerouslySetInnerHTML= {{__html: thePreview}}></div>
    </div>
  )
}
