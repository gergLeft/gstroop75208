<?php
  global $wpdb;

  if (ECOMMERCE_ENABLED) {
    //get IDs of all product posts so that we may exclude them from The Loop
    $theResult = $wpdb->get_results("SELECT ID FROM $wpdb->posts " . 
      " WHERE post_type = 'wpsc-product'");

    $search_exclusion = array();

    //fill array with all IDs from query
    foreach ($theResult as $row) {
      $search_exclusion[] = $row->ID;
    }
  }

  //remove pages that don't need to be in the result set: 
  $search_exclusion[] = get_ID_by_slug(SEARCH_RESULT_PAGE_NAME);
  $site_current_page = get_url_query_var(SITE_RESULT_PAGE, 1);
  
  $search_args = array(
    'post_type' => array('post', 'page'),
    'posts_per_page' => POSTS_PER_PAGE,
    's' => $search_term,
    'paged' => $site_current_page,
    'post__not_in' => $search_exclusion
  );

  $wp_query = new WP_Query($search_args);

  $rangeStart = POSTS_PER_PAGE*($site_current_page-1)+1;
  $rangeEnd = $rangeStart + POSTS_PER_PAGE;
  if ($rangeEnd > $wp_query->found_posts) {
    $rangeEnd = $wp_query->found_posts;
  }

  $last_page = ceil($wp_query->found_posts / POSTS_PER_PAGE);
?>

<?php if ( 0 < $wp_query->found_posts) : ?>
<h2>There were <?= $wp_query->found_posts; ?> results found for &quot;<?= $search_term; ?>&quot;</h2>
<?php 
  //display individual results
  while ( $wp_query->have_posts() ) :
    $wp_query->the_post();
?>
  <div>	
    <hr class="partial-bottom">

    <h4>
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h4>
    <div class="date">
      Posted on <?php the_date("F js"); ?>, by <?php the_author(); ?>					
    </div>	 

    <!-- Thumbnail + Excerpt-->
    <div>
      <p><?php the_post_thumbnail("blog_hero"); ?></p>
      <p><?php the_excerpt(); ?></p>
    </div> 
  </div>
<?php 
  endwhile; 
  wp_reset_postdata();
?>

<div class="clear-fix"></div>

<div class="article_nav">
  <hr>
  <div class="p button">
    
  <?php //show pagination (pre/next, last 2, this one, next 2) ?>
  <?php if ($site_current_page > 2) : ?>
  <a class="search-nav search-first" href="<?= SEARCH_RESULT_PAGE_NAME; ?>?<?= SEARCH_QUERY_PARAM ?>=<?= $search_term; ?>">&lt;&lt;</a>
  <?php endif; ?>
  
  <?php if ($site_current_page > 2) : ?>
  <a class="search-nav search-page" href="<?= SEARCH_RESULT_PAGE_NAME; ?>?<?= SEARCH_QUERY_PARAM ?>=<?= $search_term; ?>&<?= SITE_RESULT_PAGE ?>=<?= $site_current_page-2; ?>"><?= $site_current_page-2; ?></a>
  <?php endif; ?>
  
  <?php if ($site_current_page > 1) : ?>
  <a class="search-nav search-page" href="<?= SEARCH_RESULT_PAGE_NAME; ?>?<?= SEARCH_QUERY_PARAM ?>=<?= $search_term; ?>&<?= SITE_RESULT_PAGE ?>=<?= $site_current_page-1; ?>"><?= $site_current_page-1; ?></a>
  <?php endif; ?>
  
  <span class="search-nav search-page current-page"><?= $site_current_page; ?></span>
  
  <?php if ($site_current_page < $last_page) : ?>
  <a class="search-nav search-prev" href="<?= SEARCH_RESULT_PAGE_NAME; ?>?<?= SEARCH_QUERY_PARAM ?>=<?= $search_term; ?>&<?= SITE_RESULT_PAGE ?>=<?= $site_current_page+1; ?>"><?= $site_current_page+1; ?></a>
  <?php endif; ?>
  
  <?php if ($site_current_page < $last_page-1) : ?>
  <a class="search-nav search-prev" href="<?= SEARCH_RESULT_PAGE_NAME; ?>?<?= SEARCH_QUERY_PARAM ?>=<?= $search_term; ?>&<?= SITE_RESULT_PAGE ?>=<?= $site_current_page+2; ?>"><?= $site_current_page+2; ?></a>
  <?php endif; ?>
  
  <?php if ($site_current_page < $last_page-1) : ?>
  <a class="search-nav search-first" href="<?= SEARCH_RESULT_PAGE_NAME; ?>?<?= SEARCH_QUERY_PARAM ?>=<?= $search_term; ?>&<?= SITE_RESULT_PAGE ?>=<?= $last_page; ?>">&gt;&gt;</a>
  <?php endif; ?>

</div>
<!-- </Previous / More Entries -->

<?php else : ?>
  <div class="search-result-summary">
    <div class="no-results"><h2>No results found for &quot;<?= $search_term; ?>&quot;</h2></div>
  </div>
<?php endif; ?>