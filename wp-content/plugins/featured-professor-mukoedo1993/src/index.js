import "./index.scss"
import {useSelect} from "@wordpress/data"
console.log(useSelect)
console.log("nimasile")


wp.blocks.registerBlockType("ourplugin/featured-professor", {
  title: "Professor Callout",
  description: "Include a short description and link to a professor of your choice",
  icon: "welcome-learn-more",
  category: "common",
  attributes: {
  	profId: {type: "string"} //Argument: even though
  	//profId should be number, but consider how WP actually loads data at the database
  	// and just for general comparison <--- use string as a type here.
  },
  edit: EditComponent,
  save: function () {
    return null
  }
})

function EditComponent(props) {
  const allProfs = useSelect(select => {
    return select("core").getEntityRecords("postType", "professor", {per_page: -1})
  })
  
  console.log(allProfs)

  if (allProfs == undefined) return <p>Loading...</p>	//for waiting for loading
  //async: so, if still not loaded, allProfs will be undefined here. But as soon as our code
  // loaded, our code will be rendered.

  return (
    <div className="featured-professor-wrapper">
      <div className="professor-select-container">
        <select onChange={e => props.setAttributes({profId: e.target.value})}>
        <option value="">Select a professor</option>
	{allProfs.map(prof => {
	  return (
	    <option value={prof.id} selected={props.attributes.profId == prof.id}>
	    {prof.title.rendered}
	    </option>
	  )
	})}
        </select>
      </div>
      <div>
        The HTML preview of the selected professor will appear here.
      </div>
    </div>
  )
}
