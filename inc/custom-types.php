<?php

// Exit if accessed directly
if (!defined( 'ABSPATH')) exit;

//------------------------//
//--- Custom Post Type ---//
//------------------------//
add_action('init', 'bwpg_register_custom_post_type');
function bwpg_register_custom_post_type() {

  $labels = [
    "name" => __( "Glossary Word", "best_wp_glossary" ),
    "singular_name" => __( "Glossary Words", "best_wp_glossary" ),
  ];

  $args = [
    "label" => __( "Glossary Word", "best_wp_glossary" ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "show_in_rest" => true,
    "rest_base" => "",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "has_archive" => false,
    "show_in_menu" => 'bwpg',
    "show_in_nav_menus" => true,
    "delete_with_user" => false,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => [ "slug" => "bwpg_term", "with_front" => true ],
    "query_var" => true,
    "menu_position" => 6,
    "menu_icon" => "dashicons-edit-page",
    "supports" => [ "title", "editor" ],
    "taxonomies" => [ "bwpg_initial" ],
  ];

  register_post_type( "bwpg_word", $args );
}

//-----------------------//
//--- Custom Taxonomy ---//
//-----------------------//
add_action('init', 'bwpg_register_custom_taxonomy');
function bwpg_register_custom_taxonomy() {

  $labels = [
    "name" => __( "Glossary Initials", "best_wp_glossary" ),
    "singular_name" => __( "Glossary Initial", "best_wp_glossary" ),
  ];

  $args = [
    "label" => __( "Glossary Initials", "best_wp_glossary" ),
    "labels" => $labels,
    "public" => true,
    "publicly_queryable" => true,
    "hierarchical" => false,
    "show_ui" => false,
    "show_in_menu" => false,
    "show_in_nav_menus" => false,
    "query_var" => true,
    "rewrite" => [ 'slug' => 'bwpg_initial', 'with_front' => true, ],
    "show_admin_column" => false,
    "show_in_rest" => true,
    "rest_base" => "bwpg_initial",
    "rest_controller_class" => "WP_REST_Terms_Controller",
    "show_in_quick_edit" => false,
  ];

  register_taxonomy( "bwpg_initial", [ "bwpg_word" ], $args );
}
