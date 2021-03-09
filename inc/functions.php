<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

//--------------------//
//--- Get Settings ---//
//--------------------//
function bwpg_get_settings() {

  $defaults = [
    'accent_color' => '#1E90FF',
  ];

  $settings = wp_parse_args(get_option('bwpg_settings', $defaults), $defaults);

  return $settings;
}
