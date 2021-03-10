<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;


//--------------------------//
//--- Save Glossary Term ---//
//--------------------------//
add_action('save_post_bwpg_word', 'bwpg_save_glossary_word');
function bwpg_save_glossary_word($post_id) {

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  $post = get_post($post_id);

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  if (isset($post->post_status) && 'auto-draft' == $post->post_status) {
    return;
  }

  $taxonomy = 'bwpg_initial';

  $initial = substr(strtoupper($post->post_title), 0, 1);

  if (is_numeric($initial)) {
    $initial = '0-9';
  }

  wp_set_post_terms($post_id, $initial, $taxonomy);
}


//--------------------------------------//
//--- Adds a metabox to CPT Glossary ---//
//--------------------------------------//
add_action('add_meta_boxes', 'bwpg_add_word_metaboxes');
function bwpg_add_word_metaboxes() {
  add_meta_box(
    'bwpg_word_metabox',
    'Glosarios',
    'bwpg_word_metabox_content',
    'bwpg_word',
    'side',
    'high'
  );
}


//---------------------------------//
//--- HTML for the Word Metabox ---//
//---------------------------------//
function bwpg_word_metabox_content() {
  global $post;

  // Nonce field to validate form request came from current site
  wp_nonce_field('bwpg_metabox_nonce', 'bwpg_nonce');

  $postmeta = get_post_meta($post->ID, 'bwpg_glossaries', true);

  // Get the Glossaries
  $args = [
    'post_type' => 'bwpg_glossary',
    'posts_per_page' => -1
  ];
  $glossaries = get_posts($args);

  echo '<h4>' . __('Select the glossaries where this word should appear.') . '</h4>';

  foreach ($glossaries as $glossary) {

    if (is_array($postmeta) && in_array($glossary->ID, $postmeta)) {
      $checked = 'checked="checked"';
    } else {
      $checked = null;
    }

    echo ' <input type="checkbox" name="bwpg_glossaries[]" value="' . $glossary->ID . '" ' . $checked . '> ' . $glossary->post_title . '<br>';
  }
}


//-------------------------//
//--- Save Word Metadata ---//
//-------------------------//
add_action('save_post', 'bwpg_save_meta');
function bwpg_save_meta($post_id) {

  if (!isset($_POST['bwpg_nonce']) || !wp_verify_nonce($_POST['bwpg_nonce'], 'bwpg_metabox_nonce'))
    return;

  if (!current_user_can('edit_post', $post_id))
    return;

  // Glossaries where the word must be shown
  if (isset($_POST['bwpg_glossaries'])) {
    update_post_meta($post_id, 'bwpg_glossaries', $_POST['bwpg_glossaries']);
  }

}


//------------------------------------------//
//--- Filter the Single Glossary Content ---//
//------------------------------------------//
add_filter('the_content', 'bwpg_single_glossary_content');
function bwpg_single_glossary_content($content) {
  if (is_singular('bwpg_glossary') && is_main_query()) {

    ob_start();

    include(BWPG_PATH . '/templates/single-glossary.php');

    $content .= ob_get_clean();
  }

  return $content;
}


//--------------------------------------//
//--- Custom Archive for Glossary CPT---//
//--------------------------------------//
add_filter('template_include', 'bwpg_glossary_archive_template');
function bwpg_glossary_archive_template( $template ) {
  if ( is_post_type_archive('bwpg_glossary') ) {
    $theme_files = array('archive-bwpg_glossary.php', 'best-wp-glossary/archive-bwpg_glossary.php');
    $exists_in_theme = locate_template($theme_files, false);
    if ($exists_in_theme != '') {
      return $exists_in_theme;
    } else {
      return BWPG_PATH . '/templates/archive-glossary.php';
    }
  }
  return $template;
}