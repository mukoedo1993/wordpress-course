<?php

/*
  Plugin Name: Featured Professor Block Type following Brad's course-mukoedo1993
  Version: 1.0
  Author: Tom Kim
  Author URI: https://www.udemy.com/user/bradschiff/
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once plugin_dir_path(__FILE__) . 'inc/generateProfessorHTML.php';

class FeaturedProfessor {
  function __construct() {
    add_action('init', [$this, 'onInit']);
    add_action('rest_api_init', [$this, 'profHTML']);
  }

  function profHTML() {
    register_rest_route('featuredProfessor/v1', 'getHTML', array(
      'methods' => WP_REST_SERVER::READABLE,
      'callback' => [$this, 'getProfHTML']
    )); 
    /*
    * namespace, route-name, arr...
    */
  }

  function getProfHTML($data) {
    return generateProfessorHTML($data['profId']);

  }

  function onInit() {
  
    register_meta('post', 'featuredprofessor', array(
      'show_in_rest' => true,
       'type' => 'number',
       'single' => false
       /*argument:
       * If you set single as true, in database, WP will try to store an array
       * of data for the values. But in certain situations that could serialize the
       * data and then database lookup performance is a bit slower. So, by setting single
       * to false, we've just saying you don't need to try to save all of the professor ids 
       * in one row or one entry. Instead, if we had three featured professors in one blog post,
       * we could have three rows or three entries in database.
       */
    )); 
    /*
    * 1st param: type of metadata
    * 2nd param: name of metadata
    * 3rd param: array of options
    * 3rd param: 
    */
  
    wp_register_script('featuredProfessorScript', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-i18n', 'wp-editor'));
    wp_register_style('featuredProfessorStyle', plugin_dir_url(__FILE__) . 'build/index.css');

    register_block_type('ourplugin/featured-professor', array(
      'render_callback' => [$this, 'renderCallback'],
      'editor_script' => 'featuredProfessorScript',
      'editor_style' => 'featuredProfessorStyle'
    ));
  }

  function renderCallback($attributes) {
    if ($attributes['profId']) {
      wp_enqueue_style('featuredProfessorStyle');
      return generateProfessorHTML($attributes['profId']);
    } else {
      return NULL;
    }
  }

}

$featuredProfessor = new FeaturedProfessor();

//This file should be top-level view, or, bird's eye view of everything our block is doing.
