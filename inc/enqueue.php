<?php

// Exit if accessed directly
if (!defined( 'ABSPATH')) exit;


//-------------------------------//
//--- Public Scripts & Styles ---//
//-------------------------------//
add_action('wp_enqueue_scripts', 'bwpg_public_scripts_styles', 10000);
function bwpg_public_scripts_styles() {

  // JS Script
  wp_enqueue_script('bwpg-bundle-js', BWPG_URL . '/dist/js/bwpg-bundle.js', array('jquery'), BWPG_VERSION, true);

  // CSS Stylesheet
  wp_enqueue_style('bwpg-bundle-css', BWPG_URL . '/dist/css/bwpg-bundle.css', array(), BWPG_VERSION);

  // User styles
  include_once BWPG_PATH . '/inc/user-styles.php';
}


//------------------------------//
//--- Admin Scripts & Styles ---//
//------------------------------//
add_action( 'admin_enqueue_scripts', 'bwpg_admin_scripts_styles');
function bwpg_admin_scripts_styles($hook) {

  // Do not load if we are not in the plugin settings page
  if (!strstr($hook, 'bwpg-settings')) {
    return;
  }

  // Color Picker
  wp_enqueue_style('wp-color-picker');
  wp_enqueue_script('bwpg-admin-js', BWPG_URL . '/dist/js/bwpg-admin.js', array('jquery', 'wp-color-picker'), BWPG_VERSION);

}
