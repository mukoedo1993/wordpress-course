import "./index.scss"
import {TextControl, Flex, FlexBlock, FlexItem, Button, Icon, PanelBody, PanelRow, ColorPicker} from "@wordpress/components"	//npm install here NOT needed. WP team has solved this.

import {InspectorControls} from "@wordpress/block-editor"
import {ChromePicker} from "react-color"

(function() {
	let locked = false

	wp.data.subscribe(function() {	//catch any time our block changes. (work with up-to-date data.)
		const results = wp.data.select("core/block-editor").getBlocks().filter(function(block) {
			return block.name == "ourplugin/are-you-paying-attention" && block.attributes.correctAnswer == undefined
		})
		
		if (results.length && locked == false) {
		  locked = true
		  wp.data.dispatch("core/editor").lockPostSaving("noanswer")
		}
		
		if (!results.length && locked) {
		  locked = false
		  wp.data.dispatch("core/editor").unlockPostSaving("noanswer")
		}
	})
})()


wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
  title: "Are You Paying Attention?",
  icon: "smiley",
  category: "common",
  attributes: {
    question: {type: "string"},	//source here 
    answers: {type: "array", default: [""]}, //default here is an array of actual answer strings
    correctAnswer: {type: "number", default: undefined},
    bgColor: {type: "string", default: "#EBEBEB"} //lightgray by default
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
   	  
   	  if (indexToDelete == props.attributes.correctAnswer) {
   	  	props.setAttributes({correctAnswer: undefined})	//Because we've deleted wrong answer here.
   	  }
   	}
   	
       function markAsCorrect(index) {
        props.setAttributes({correctAnswer: index})
       
       }
   
  	return (
  		<div className="paying-attention-edit-block" style={{backgroundColor: props.attributes.bgColor}}> 
  		 <InspectorControls>
  		   <PanelBody title="Background Color" initialOpen={true}>
  		    <PanelRow>
  		      <ChromePicker color={props.attributes.bgColor} onChangeComplete={x => props.setAttributes({bgColor: x.hex})} disableAlpha={true/*no alpha transparency*/}/>
  		    </PanelRow>
  		   </PanelBody>
  		 </InspectorControls>
  		 <TextControl label="Question:" value={props.attributes.question} onChange={updateQuestion} style={{fontSize: "20px"}} />
  		 <p style={{fontSize: "13px", margin: "20px 0 8px 0"}}>Answers: </p>
		 {props.attributes.answers.map(function (answer, index) {
		   return (
		<Flex>
  		   <FlexBlock>
  		    <TextControl autoFocus={answer == undefined} value={answer} onChange={newValue => {
  		      const newAnswers = props.attributes.answers.concat([])	//deep copy an array
  		      newAnswers[index] = newValue 
  		      console.log(newAnswers[index])
  		      console.log(index)
  		      console.log(newAnswers.length)
  		      props.setAttributes({answers: newAnswers})
  		    
  		    }} />
  		   </FlexBlock> 
  		   <FlexItem>
  		    <Button onClick={() => markAsCorrect(index)}>
  		      <Icon className="mark-as-correct" icon={props.attributes.correctAnswer == index ? "star-filled" : "star-empty"} />
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
  		      props.setAttributes({answers: props.attributes.answers.concat([undefined])/*undefined here is used to differentiate new value with previous values.*/})
  		    }}>Add another answer</Button>
  		  </FlexItem>
  		</div>
  	)/*
  	* FlexBlock will take as much area as it can.
  	* FlexItem only takes smallest amount of space they need.
  	* isLink implies it's a permalink and will underline this element.
  	*/
  }
