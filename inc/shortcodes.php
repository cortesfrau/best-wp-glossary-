<?php

// Exit if accessed directly
if (!defined( 'ABSPATH')) exit;

//-------------------------//
//--- Archive Shortcode ---//
//-------------------------//
add_shortcode('wpbg_archive', 'wpbg_archive_function');
function wpbg_archive_function() {

  ob_start();

  include(WPBG_PATH . '/templates/archive.php');

  return ob_get_clean();
}
