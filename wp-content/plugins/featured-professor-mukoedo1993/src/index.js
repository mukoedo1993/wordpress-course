import "./index.scss"

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
  return (
    <div className="featured-professor-wrapper">
      <div className="professor-select-container">
        <select onChange={e => props.setAttributes({profId: e.target.value})}>
        <option value="">Select a professor</option>
        <option value="1" selected={props.attributes.profId == 1}>1</option>
        <option value="2" selected={props.attributes.profId == 2}>2</option>
        <option value="3" selected={props.attributes.profId == 3}>3</option>
        </select>
      </div>
      <div>
        The HTML preview of the selected professor will appear here.
      </div>
    </div>
  )
}
