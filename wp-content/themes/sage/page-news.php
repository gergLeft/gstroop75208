<?php get_template_part('templates/page', 'header'); ?>

<?php
  $args = array();
  $args['post_type'] = 'post';
  $args['orderby'] = 'date';
  $args['order'] = 'DESC';
  $newsFeed = new wp_query($args);
?>

<?php if (!$newsFeed->have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<?php 
  while ($newsFeed->have_posts()) : $newsFeed->the_post();
    get_template_part('templates/content');
  endwhile; 
  wp_reset_postdata();
?>

<?php the_posts_navigation(); ?>
