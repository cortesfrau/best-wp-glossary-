<?php

// Exit if accessed directly
if (!defined( 'ABSPATH')) exit;


//------------------------------//
//--- Register Options Pages ---//
//------------------------------//
add_action('admin_menu','wpbg_register_options_page');
function wpbg_register_options_page() {
  add_menu_page(
    'WP Best Glossary',
    'WP Best Glossary',
    'edit_pages',
    'wpbg',
    '',
    'dashicons-edit-page',
    6
  );
  add_submenu_page(
    'wpbg',
    __('WP Best Glossary Settings', 'wpbg'),
    __('Settings', 'wpbg'),
    'edit_pages',
    'wpbg-settings',
    'wpbg_settings_page'
  );
}


//----------------//
//--- SETTINGS ---//
//----------------//

// Register settings
add_action('admin_init', 'wpbg_register_settings');
function wpbg_register_settings() {
  register_setting( 'wpbg_settings', 'wpbg_settings' );
}

// Settings page content
function wpbg_settings_page() {

  // Get Settings
  $settings = wpbg_get_settings();

  ?>

  <div class="wrap">

    <h1>Better WP Login Page</h1>

    <h2><?php _e('Shortcodes', 'wpbg'); ?></h2>
    <p><?php _e('Use these shortcodes to show the glossary content in any page or post.','wpbg'); ?></p>

    <table class="form-table">
      <tr>
        <th><?php _e('Glossary archive','wpbg'); ?></th>
        <td><code>[wpbg_archive]</code></td>
      </tr>
    </table>

    <h2><?php _e('Styles', 'wpbg'); ?></h2>

    <form method="post" action="options.php">

      <?php settings_fields( 'wpbg_settings' ); ?>
      <?php do_settings_sections( 'wpbg_settings_page' ); ?>

      <!-- Colors : START -->
      <h3><?php echo __( 'Colors', 'wpbg'); ?></h3>
      <p><?php _e('Enter colors sin hex format (Example: #1E90FF)', 'wpbg'); ?></p>
      <table class="form-table">
        <tr>
          <th><?php echo __( 'Accent color', 'wpbg' ); ?></th>
          <td><input type="text" name="wpbg_settings[accent_color]" value="<?php echo $settings['accent_color']; ?>"/></td>
        </tr>
      </table>

      <?php submit_button(); ?>

    </form>

  </div>

<?php }
