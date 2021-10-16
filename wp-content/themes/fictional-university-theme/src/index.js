import "../css/style.scss"

// Our modules / classes
import MobileMenu from "./modules/MobileMenu" 
/*
For small devices. If you resize your browser be very small and very narrow,
you will see the menu icon in the top right corner you can click on to view the
navigation menu.
*/


import HeroSlider from "./modules/HeroSlider"
/*
JS that powers the slideshow at the bottom of our homepage.
*/

import Search from "./modules/Search"

import MyNotes from "./modules/MyNotes"

// Instantiate a new object using our modules/classes
const mobileMenu = new MobileMenu()
const heroSlider = new HeroSlider()

const search = new Search()

const myNotes = new MyNotes()
