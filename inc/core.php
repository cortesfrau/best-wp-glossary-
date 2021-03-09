<?php

// Exit if accessed directly
if (!defined( 'ABSPATH')) exit;

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
