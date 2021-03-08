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
define('WPBG_VERSION', '1.0.0');
define('WPBG_BASE', __FILE__);
define('WPBG_PATH', __DIR__);
define('WPBG_URL', plugins_url('', WPBG_BASE));
define('WPBG_BASENAME', plugin_basename( __FILE__));


//----------------//
//--- Includes ---//
//----------------//
require_once WPBG_PATH . '/inc/functions.php';
require_once WPBG_PATH . '/inc/custom-types.php';
require_once WPBG_PATH . '/inc/enqueue.php';
require_once WPBG_PATH . '/inc/shortcodes.php';
require_once WPBG_PATH . '/inc/core.php';
require_once WPBG_PATH . '/inc/setup.php';
