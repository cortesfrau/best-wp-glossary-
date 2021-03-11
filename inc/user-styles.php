<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

$settings = bwpg_get_settings();

$accent_color = $settings['accent_color'];

?>

<style type="text/css">

  :root {
    --bwpg-accent-color: <?php echo $accent_color; ?>;
    --bwpg-white: #fff;
  }

  /*--------------------------*/
  /*--- Archive Navigation ---*/
  /*--------------------------*/
  #bwpg-archive-nav a {
    color: var(--bwpg-white) !important;
    border-color: var(--bwpg-accent-color) !important;
    background-color: var(--bwpg-accent-color) !important;
  }
  #bwpg-archive-nav a:hover,
  #bwpg-archive-nav a:focus,
  #bwpg-archive-nav a:active {
    background-color: transparent !important;
    color: var(--bwpg-accent-color) !important;
  }

</style>
