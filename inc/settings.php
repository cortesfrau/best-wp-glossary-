<?php

// Exit if accessed directly
if (!defined( 'ABSPATH')) exit;


//------------------------------//
//--- Register Options Pages ---//
//------------------------------//
add_action('admin_menu','bwpg_register_options_page');
function bwpg_register_options_page() {
  add_menu_page(
    'WP Best Glossary',
    'WP Best Glossary',
    'edit_pages',
    'bwpg',
    '',
    'dashicons-edit-page',
    6
  );
  add_submenu_page(
    'bwpg',
    __('WP Best Glossary Settings', 'best_wp_glossary'),
    __('Settings', 'best_wp_glossary'),
    'edit_pages',
    'bwpg-settings',
    'bwpg_settings_page'
  );
}


//----------------//
//--- SETTINGS ---//
//----------------//

// Register settings
add_action('admin_init', 'bwpg_register_settings');
function bwpg_register_settings() {
  register_setting( 'bwpg_settings', 'bwpg_settings' );
}

// Settings page content
function bwpg_settings_page() {

  // Get Settings
  $settings = bwpg_get_settings();

  ?>

  <div class="wrap">

    <h1>Better WP Login Page</h1>

    <h2><?php _e('Shortcodes', 'best_wp_glossary'); ?></h2>
    <p><?php _e('Use these shortcodes to show the glossary content in any page or post.','best_wp_glossary'); ?></p>

    <table class="form-table">
      <tr>
        <th><?php _e('Glossary archive','best_wp_glossary'); ?></th>
        <td><code>[bwpg_archive]</code></td>
      </tr>
    </table>

    <form method="post" action="options.php">

      <?php settings_fields( 'bwpg_settings' ); ?>
      <?php do_settings_sections( 'bwpg_settings_page' ); ?>

      <!-- Colors : START -->
      <h3><?php echo __( 'Colors', 'best_wp_glossary'); ?></h3>
      <p><?php _e('Enter colors in HEX format. Example: #1E90FF', 'best_wp_glossary'); ?></p>
      <table class="form-table">
        <tr>
          <th><label for="accent-color"></label><?php echo __( 'Accent color', 'best_wp_glossary' ); ?></th>
          <td><input id="accent-color" class="color-picker" data-alpha-enabled="true" type="text" name="bwpg_settings[accent_color]" value="<?php echo $settings['accent_color']; ?>"/></td>
        </tr>

      </table>

      <?php submit_button(); ?>

    </form>

  </div>

<?php }
