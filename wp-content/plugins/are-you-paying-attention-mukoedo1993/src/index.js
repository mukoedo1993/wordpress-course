import "./index.scss"
import {TextControl, Flex, FlexBlock, FlexItem, Button, Icon} from "@wordpress/components"	//npm install here NOT needed. WP team has solved this.

wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
  title: "Are You Paying Attention?",
  icon: "smiley",
  category: "common",
  attributes: {
    question: {type: "string"},	//source here 
    answers: {type: "array", default: ["red", "blue", "green"]} //default here is an array of actual answer strings
  },
  edit: EditComponent,
  save: function (props) {
  	return null
  },
  

  
})

function EditComponent (props) {
  	  	
   	function updateQuestion(value) {
   	  	props.setAttributes({question: value})
   	}
   	
   	function deleteAnswer(indexToDelete) {
   	  const newAnswers = props.attributes.answers.filter(function(x, index) {
   	  	return index != indexToDelete
   	  })
   	  props.setAttributes({answers: newAnswers})
   	}
   
  	return (
  		<div className="paying-attention-edit-block"> 
  		 <TextControl label="Question:" value={props.attributes.question} onChange={updateQuestion} style={{fontSize: "20px"}} />
  		 <p style={{fontSize: "13px", margin: "20px 0 8px 0"}}>Answers: </p>
		 {props.attributes.answers.map(function (answer, index) {
		   return (
		<Flex>
  		   <FlexBlock>
  		    <TextControl value={answer} onChange={newValue => {
  		      const newAnswers = props.attributes.answers.concat([])	//deep copy an array
  		      newAnswers[index] = newValue 
  		      console.log(newAnswers[index])
  		      console.log(index)
  		      console.log(newAnswers.length)
  		      props.setAttributes({answers: newAnswers})
  		    
  		    }} />
  		   </FlexBlock> 
  		   <FlexItem>
  		    <Button>
  		      <Icon className="mark-as-correct" icon="star-empty" />
  		    </Button>
  		   </FlexItem>
  		   <FlexItem>
  		    <Button isLink className="attention-delete" onClick={() => deleteAnswer(index)}>Delete</Button>
  		   </FlexItem>
  		 </Flex>
		   )
		 })}
  		  <FlexItem>
  		    <Button isPrimary onClick={() => {
  		      props.setAttributes({answers: props.attributes.answers.concat([""])})
  		    }}>Add another answer</Button>
  		  </FlexItem>
  		</div>
  	)/*
  	* FlexBlock will take as much area as it can.
  	* FlexItem only takes smallest amount of space they need.
  	* isLink implies it's a permalink and will underline this element.
  	*/
  }
