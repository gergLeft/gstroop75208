<?php 
  global $rankParent;
  $rankParent = \Roots\Sage\Extras\get_rank_category_id();
?>
  
<?php get_template_part('templates/page', 'header'); ?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<?php 
  while (have_posts()) : the_post();
    get_template_part('templates/content-news');
  endwhile; 
  wp_reset_postdata();
?>

<?php the_posts_navigation(); ?>
