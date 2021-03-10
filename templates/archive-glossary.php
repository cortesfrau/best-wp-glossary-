<?php

// Exit if accessed directly
if (!defined( 'ABSPATH')) exit;

get_header();

// Arguments for the Glossary loop
$args = array(
  'post_type' => 'bwpg_glossary',
  'posts_per_page' => -1,
);
$glossaries = get_posts($args);

?>

<div class="bwpg-container">

  <h1 class="bwpg-archive-title"><?php _e('Glossaries','best-wp-glossary'); ?></h1>

  <div class="bwpg-row">

    <?php foreach ($glossaries as $glossary) {
      $thumb = get_the_post_thumbnail_url($glossary->ID, 'bwpg_landscape_thumb');
      if (empty($thumb)) $thumb = BWPG_URL . '/dist/img/default.png';
      $url = get_the_permalink($glossary->ID);
      $title = $glossary->post_title;
      ?>

    <div class="bwpg-col-md-6 bwpg-col-lg-4 bwpg-col-xl-3">

      <div class="bwpg-glossary-item" style="background-image: url(<?php echo $thumb; ?>">

        <div class="bwpg-glossary-item-overlay"></div>

        <a class="bwpg-glossary-item-link" href="<?php echo $url; ?>">

          <h2 class="bwpg-glossary-item-title">

            <?php echo $title; ?>

          </h2>

        </a>

      </div>

    </div>

    <?php } ?>

  </div>

</div>

<?php

get_footer();
