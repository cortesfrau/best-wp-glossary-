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


//--------------------------------//
//--- Get Initials of Glossary ---//
//--------------------------------//
function bwpg_get_glossary_initials_objects($glossary_id) {

  $initials_ids = [];

  $words = get_posts(array(
    'post_type' => 'bwpg_word',
    'posts_per_page' => -1,
    'order' => 'ASC',
    'orderby' => 'title',
    'meta_query' => array(
      array(
        'key' => 'bwpg_glossaries',
        'value' => $glossary_id,
        'compare' => 'LIKE'
      ),
    ),
  ));

  foreach ($words as $word) {
    $initial_id = get_the_terms($word->ID, 'bwpg_initial')[0]->term_id;
    if (!in_array($initial_id, $initials_ids)) {
      $initials_ids[] = $initial_id;
    }
  }

  // Get Initials Objects
  $initials_objects = get_terms(array(
    'taxonomy' => 'bwpg_initial',
    'hide_empty' => true,
    'include' => $initials_ids,
  ));

  return $initials_objects;
}
