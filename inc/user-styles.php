<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

$settings = wpbg_get_settings();

$accent_color = $settings['accent_color'];

?>

<style type="text/css">

  :root {
    --wpbg-accent-color: <?php echo $accent_color; ?>;
    --wpbg-white: #fff;
  }

  /*--------------------------*/
  /*--- Archive Navigation ---*/
  /*--------------------------*/
  #wpbg-archive-nav a {
    color: var(--wpbg-accent-color) !important;
    border-color: var(--wpbg-accent-color) !important;
  }
  #wpbg-archive-nav a:hover,
  #wpbg-archive-nav a:focus,
  #wpbg-archive-nav a:active {
    background-color: var(--wpbg-accent-color) !important;
    color: var(--wpbg-white) !important;
  }

</style>
