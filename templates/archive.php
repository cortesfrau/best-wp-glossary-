<?php

// Exit if accessed directly
if (!defined( 'ABSPATH')) exit;


// Get all initials
$wpbg_initials = get_terms( 'wpbg_initial');

// Arguments for the WP Query
$args = [
  'post_type' => 'wpbg_word',
  'posts_per_page' => -1,
];

?>

<nav id="wpbg-archive-nav">

  <?php foreach ($wpbg_initials as $wpbg_initial) { ?>

    <li><a href="<?php echo '#' . $wpbg_initial->slug; ?>"><?php echo $wpbg_initial->name; ?></a></li>

  <?php } ?>

</nav>

<?php foreach ($wpbg_initials as $wpbg_initial) { ?>

  <h2 class="wpbg-initial-title" id="<?php echo $wpbg_initial->slug; ?>"><?php echo $wpbg_initial->name; ?></h2>

  <?php $args['tax_query'] = array(
    array (
      'taxonomy' => 'wpbg_initial',
      'field' => 'slug',
      'terms' => $wpbg_initial->slug,
    ));

  $wpbg_words = new WP_Query($args);

  while ($wpbg_words->have_posts()) : $wpbg_words->the_post(); ?>

    <h3 class="wpbg-word-title"><?php echo get_the_title(); ?></h3>

    <div class="wpbg-content">

      <?php the_content(); ?>

    </div>

  <?php endwhile; wp_reset_postdata();

}
