<?php

// Exit if accessed directly
if (!defined( 'ABSPATH')) exit;


// Get all initials
$bwpg_initials = get_terms( 'bwpg_initial');

// Arguments for the WP Query
$args = [
  'post_type' => 'bwpg_word',
  'posts_per_page' => -1,
];

?>

<nav id="bwpg-archive-nav">

  <?php foreach ($bwpg_initials as $bwpg_initial) { ?>

    <li><a href="<?php echo '#' . $bwpg_initial->slug; ?>"><?php echo $bwpg_initial->name; ?></a></li>

  <?php } ?>

</nav>

<?php foreach ($bwpg_initials as $bwpg_initial) { ?>

  <h2 class="bwpg-initial-title" id="<?php echo $bwpg_initial->slug; ?>"><?php echo $bwpg_initial->name; ?></h2>

  <?php $args['tax_query'] = array(
    array (
      'taxonomy' => 'bwpg_initial',
      'field' => 'slug',
      'terms' => $bwpg_initial->slug,
    ));

  $bwpg_words = new WP_Query($args);

  while ($bwpg_words->have_posts()) : $bwpg_words->the_post(); ?>

    <h3 class="bwpg-word-title"><?php echo get_the_title(); ?></h3>

    <div class="bwpg-content">

      <?php the_content(); ?>

    </div>

  <?php endwhile; wp_reset_postdata();

}
