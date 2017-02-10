    <?php /*<?php
?>
<article <?php post_class(); ?>>
  <div class="contentFrame frameCnt<?php echo sizeof($rankCats); ?>">
    <?php 
      $f = 1;
      foreach ($rankCats as $rc) : 
    ?>
    <div class="frame frame<?php echo $f++; ?> <?php echo $rc->slug; ?>BG"></div>
    <?php 
      endforeach; 
    ?>
    <div class="contentBlock">
      <header>
        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php get_template_part('templates/entry-meta'); ?>
      </header>
      <div class="entry-summary">
        <?php the_excerpt(); ?>
      </div>
    </div>
  </div>
  
</article>
*/?>

<?php
  global $rankParent;
  $rankCats = wp_get_post_categories(get_the_ID(), array('parent'=>$rankParent, 'fields'=>'all'));
  
  if (0 === sizeof($rankCats)) :
    //no ranks selected, applies to the whole troop
    $rankCats = get_categories(array('parent'=>$rankParent));
  endif;
?>
<article <?php post_class(); ?>>
  <div class="ranksApplied">
    <?php foreach ($rankCats as $rc) : ?>
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/<?php echo $rc->slug; ?>Tag.png" />
    <?php endforeach; ?>
  </div>
  <div class="contentBlock">
    <header>
      <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <?php get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-summary">
      <?php the_excerpt(); ?>
    </div>
  </div>
  <div style="clear: both"></div>
</article>