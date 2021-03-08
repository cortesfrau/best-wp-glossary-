<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

//--------------------//
//--- Get Settings ---//
//--------------------//
function wpbg_get_settings() {

  $defaults = [
    'accent_color' => '#1E90FF',
  ];

  $settings = wp_parse_args(get_option('wpbg_settings', $defaults), $defaults);

  return $settings;
}
