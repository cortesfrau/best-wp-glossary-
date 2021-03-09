<?php

// Exit if accessed directly
if (!defined( 'ABSPATH')) exit;

//-------------------------//
//--- Archive Shortcode ---//
//-------------------------//
add_shortcode('bwpg_archive', 'bwpg_archive_function');
function bwpg_archive_function() {

  ob_start();

  include(BWPG_PATH . '/templates/archive.php');

  return ob_get_clean();
}
