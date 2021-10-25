wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
  title: "Are You Paying Attention?",
  icon: "smiley",
  category: "common",
  edit: function () {
  	return wp.element.createElement("h3", null, "Hello, this is from the admin editor screen")	//WP's official way of creating new element.
  	/*
  	* 1st param: element name
  	* 2nd param: inline style
  	* 3rd param: text inside the element.
  	*/
  },
  save: function () {
  	return wp.element.createElement("h1", null, "This is the frontend")
  }
  
})
