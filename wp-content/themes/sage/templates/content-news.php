<?php
  global $rankParent;
  $rankCats = wp_get_post_categories(get_the_ID(), array('parent'=>$rankParent, 'fields'=>'all'));
  
  switch (sizeof($rankCats)) :
    case 0:
      //no ranks selected, applies to the whole troop
      $rankCats = get_categories(array('parent'=>$rankParent));
      break;
    case 1:
       //only 1 rank selected, duplicate to all 4 corner;
      $rankCats[1] = $rankCats[0];
      $rankCats[2] = $rankCats[0];
      $rankCats[3] = $rankCats[0];
      break;
    case 2://only 1 rank selected, duplicate to all 4 corner;
      $rankCats[2] = $rankCats[0];
      $rankCats[4] = $rankCats[1];
      break;
  endswitch;
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
