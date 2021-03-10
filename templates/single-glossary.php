<?php

// Exit if accessed directly
if (!defined( 'ABSPATH')) exit;

// Global Post (Glossary)
global $post;

// Get Initials IDS
$initials = bwpg_get_glossary_initials_objects($post->ID);

?>


<nav id="bwpg-archive-nav">

  <?php foreach ($initials as $initial) { ?>

    <li><a href="<?php echo '#' . $initial->slug; ?>"><?php echo $initial->name; ?></a></li>

  <?php } ?>

</nav>

<?php foreach ($initials as $initial) { ?>

  <h2 class="bwpg-initial-title" id="<?php echo $initial->slug; ?>"><?php echo $initial->name; ?></h2>

  <?php $args = array(
    'post_type' => 'bwpg_word',
    'posts_per_page' => -1,
    'tax_query' => array(array(
      'taxonomy' => 'bwpg_initial',
      'field' => 'slug',
      'terms' => $initial->slug,
    )),
  );

  $words = get_posts($args);

    foreach ($words as $word) { ?>

      <h3 class="bwpg-word-title"><?php echo $word->post_title; ?></h3>

      <div class="bwpg-content">

        <?php echo $word->post_content; ?>

      </div>

<?php } }
