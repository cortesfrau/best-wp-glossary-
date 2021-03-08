<?php

// Exit if accessed directly
if (!defined( 'ABSPATH')) exit;

//-------------------------------//
//--- Public Scripts & Styles ---//
//-------------------------------//
add_action('wp_enqueue_scripts', 'wpbg_public_scripts_styles', 10000);
function wpbg_public_scripts_styles() {

  // JS Script
  wp_enqueue_script('wpbg-bundle-js', WPBG_URL . '/dist/js/wpbg-bundle.js', array('jquery'), WPBG_VERSION, true);

  // CSS Stylesheet
  wp_enqueue_style('wpbg-bundle-css', WPBG_URL . '/dist/css/wpbg-bundle.css', array(), WPBG_VERSION);

  // User styles
  include_once WPBG_PATH . '/inc/user-styles.php';
}
