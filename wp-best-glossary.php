<?php

/**
 * Plugin Name: WP Best Glossary
 * Text Domain: wp_best_glossary
 * Description: This plugin allows users to enhance the default login page.
 * Plugin URI: https://github.com/cortesfrau/wp-best-glossary/
 * Version: 1.0.0
 * Author: Lluís Cortès
 * Author URI: https://lluiscortes.com
 * License: GPLv2 or later
 * Domain Path: /languages
 */


// Exit if accessed directly
if (!defined( 'ABSPATH')) exit;


//-----------------//
//--- Constants ---//
//-----------------//
define('WPBG_VERSION', '1.1.0');
define('WPBG_BASE', __FILE__);
define('WPBG_PATH', __DIR__);
define('WPBG_URL', plugins_url('', WPBG_BASE));
define('WPBG_BASENAME', plugin_basename( __FILE__));


//-------------------------------//
//--- Public Scripts & Styles ---//
//-------------------------------//
add_action('public_enqueue_scripts', 'wpbg_public_scripts_styles');
function wpbg_public_scripts_styles() {

  // JS Script
  wp_enqueue_script('wpbg-public-js', WPBG_URL . '/js/wpbg-public.js', array('jquery'), WPBG_VERSION, true);

  // CSS Stylesheet
  wp_enqueue_style('wpbg-public-css', WPBG_URL . '/css/wpbg-public.css', array(), WPBG_VERSION);
}


//------------------------//
//--- Custom Post Type ---//
//------------------------//
add_action('init', 'wpbg_register_custom_post_type');
function wpbg_register_custom_post_type() {

  $labels = [
    "name" => __( "Glossary Word", "wp_best_glossary" ),
    "singular_name" => __( "Glossary Words", "wp_best_glossary" ),
  ];

  $args = [
    "label" => __( "Glossary Word", "wp_best_glossary" ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "show_in_rest" => true,
    "rest_base" => "",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "has_archive" => false,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "delete_with_user" => false,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => [ "slug" => "wpbg_term", "with_front" => true ],
    "query_var" => true,
    "menu_position" => 6,
    "menu_icon" => "dashicons-edit-page",
    "supports" => [ "title", "editor" ],
    "taxonomies" => [ "wpbg_initial" ],
  ];

  register_post_type( "wpbg_word", $args );
}

//-----------------------//
//--- Custom Taxonomy ---//
//-----------------------//
add_action('init', 'wpbg_register_custom_taxonomy');
function wpbg_register_custom_taxonomy() {

  $labels = [
    "name" => __( "Glossary Initials", "wp_best_glossary" ),
    "singular_name" => __( "Glossary Initial", "wp_best_glossary" ),
  ];

  $args = [
    "label" => __( "Glossary Initials", "wp_best_glossary" ),
    "labels" => $labels,
    "public" => true,
    "publicly_queryable" => true,
    "hierarchical" => false,
    "show_ui" => true,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "query_var" => true,
    "rewrite" => [ 'slug' => 'wpbg_initial', 'with_front' => true, ],
    "show_admin_column" => false,
    "show_in_rest" => true,
    "rest_base" => "wpbg_initial",
    "rest_controller_class" => "WP_REST_Terms_Controller",
    "show_in_quick_edit" => false,
  ];

  register_taxonomy( "wpbg_initial", [ "wpbg_word" ], $args );
}


//--------------------------//
//--- Save Glossary Term ---//
//--------------------------//
add_action('save_post_wpbg_word', 'wpbg_save_glossary_word');
function wpbg_save_glossary_word($post_id) {

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

  $taxonomy = 'wpbg_initial';

  $initial = substr(strtoupper($post->post_title), 0, 1);

  if (is_numeric($initial)) {
    $initial = '0-9';
  }

  wp_set_post_terms($post_id, $initial, $taxonomy);
}


//-------------------------//
//--- Archive Shortcode ---//
//-------------------------//
add_shortcode('wpbg_archive', 'wpbg_archive_function');
function wpbg_archive_function() {

  $wpbg_initials = get_terms( 'wpbg_initial');

  ob_start();
  ?>

  <nav id="wpbg_archive_nav">

    <?php foreach ($wpbg_initials as $wpbg_initial) { ?>

      <li><a href="<?php echo '#' . $wpbg_initial->slug; ?>"><?php echo $wpbg_initial->name; ?></a></li>

    <?php } ?>

  </nav>

  <?php $args = [
    'post_type' => 'wpbg_word',
    'posts_per_page' => -1,
  ];

  foreach ($wpbg_initials as $wpbg_initial) { ?>

    <h2 id="<?php echo $wpbg_initial->slug; ?>"><?php echo $wpbg_initial->name; ?></h2>

    <?php $args['tax_query'] = array(
      array (
        'taxonomy' => 'wpbg_initial',
        'field' => 'slug',
        'terms' => $wpbg_initial->slug,
      ));

      $wpbg_words = new WP_Query($args);

      while ($wpbg_words->have_posts()) : $wpbg_words->the_post(); ?>

      <h3><?php echo get_the_title(); ?></h3>

      <?php the_content(); endwhile; wp_reset_postdata(); ?>

  <?php } ?>

  <?
  $ob_str = ob_get_contents();
  ob_end_clean();
  return $ob_str;
}
