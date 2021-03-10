<?php

/**
 * Plugin Name: Best WP Glossary
 * Text Domain: best_wp_glossary
 * Description: This plugin allows users to create several glossaries.
 * Plugin URI: https://github.com/cortesfrau/best-wp-glossary/
 * Version: 1.1.0
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
define('BWPG_VERSION', '1.0.0');
define('BWPG_BASE', __FILE__);
define('BWPG_PATH', __DIR__);
define('BWPG_URL', plugins_url('', BWPG_BASE));
define('BWPG_BASENAME', plugin_basename( __FILE__));


//----------------//
//--- Includes ---//
//----------------//
require_once BWPG_PATH . '/inc/functions.php';
require_once BWPG_PATH . '/inc/custom-types.php';
require_once BWPG_PATH . '/inc/enqueue.php';
require_once BWPG_PATH . '/inc/core.php';
require_once BWPG_PATH . '/inc/settings.php';
