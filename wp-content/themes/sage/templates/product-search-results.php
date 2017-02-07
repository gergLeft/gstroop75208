<?php
  $pgp = get_url_query_var(PRODUCT_RESULT_PAGE, 1);
  $search_term_parts = split(" ", $search_term);
  $nameSearch = array();
  $productSearch = array();
  foreach ($search_term_parts as $term_part) {
    $nameSearch[] = "p.post_title like '%" . $term_part . "%'";
    $skuSearch[] = "sku.meta_value like '%" . $term_part . "%'";
  }
  
  // DB Query to obtain post ID, title and name
  $sqlp = "Select 
    p.ID,
    p.post_title,
    p.post_name,
    sku.meta_value as sku,
    t.term_id as brand_id,
    t.name as brand_name,
    p.post_content as description
  FROM 
    " . $table_prefix . "posts p";
 
  $results = $wpdb->get_results($sqlp);
  if (sizeof($results) > 0) :
?>

  <?php 
    $products = array();

    foreach ($results as $result):
      $wpsc_query->the_post();
    
      //get the image
      $product_id = $result->ID;
      $img_src = wp_get_attachment_image_src( wpsc_the_product_thumbnail_id($product_id), "search_results_preview" );
      
      //get the categories
      $product_categories = wp_get_object_terms(  $product_id, 'wpsc_product_category' );
      
      $products[] = array(
        "title" => $result->post_title,
        "slug" => $result->post_name,
        "image" => $img_src[0],
        "product_line_url" => get_product_line_url($result->brand_id, $all_product_lines)
      );
    endforeach;

    $product_current_page = isset($_GET[PRODUCT_RESULT_PAGE]) ? $_GET[PRODUCT_RESULT_PAGE] : 1;
    $productResultCnt = sizeof($products);
    //now that we saved the total results count, we can trim the results to this page.
    $products = array_slice($products, ($product_current_page-1)*PRODUCTS_PER_PAGE, PRODUCTS_PER_PAGE);
  ?>

  <h2>There were <?=  $productResultCnt; ?> results found for &quot;<?=  $search_term; ?>&quot;</h2>

  <div class="search-results">
      <?php foreach ($products as $product_index => $product) : ?>
        <div class="search-result-product" >
          <img src="<?=  $product["image"]; ?>" />
          <a href="<?=  $product["product_line_url"]; ?>#<?=  htmlentities($product["slug"]); ?>" >
            <?=  $product["title"]; ?>
          </a>
        </div>
    <?php endforeach; ?>

    <div class="clear-fix"></div>

    <div class="article_nav">
      <hr>
      <div class="p button">

      <?php //show pagination (pre/next, last 2, this one, next 2) ?>
      <?php if ($product_current_page > 2) : ?>
      <a class="search-nav search-first" href="<?=  SEARCH_RESULT_PAGE_NAME ?>?<?= SEARCH_QUERY_PARAM ?>=<?=  $search_term; ?>">&lt;&lt;</a>
      <?php endif; ?>

      <?php if ($product_current_page > 2) : ?>
      <a class="search-nav search-page" href="<?=  SEARCH_RESULT_PAGE_NAME ?>?<?= SEARCH_QUERY_PARAM ?>=<?=  $search_term; ?>&<?= PRODUCT_RESULT_PAGE ?>=<?=  $product_current_page-2; ?>"><?=  $product_current_page-2; ?></a>
      <?php endif; ?>

      <?php if ($product_current_page > 1) : ?>
      <a class="search-nav search-page" href="<?=  SEARCH_RESULT_PAGE_NAME ?>?<?= SEARCH_QUERY_PARAM ?>=<?=  $search_term; ?>&<?= PRODUCT_RESULT_PAGE ?>=<?=  $product_current_page-1; ?>"><?=  $product_current_page-1; ?></a>
      <?php endif; ?>

      <span class="search-nav search-page current-page"><?=  $product_current_page; ?></span>

      <?php if ($product_current_page < $last_page) : ?>
      <a class="search-nav search-prev" href="<?=  SEARCH_RESULT_PAGE_NAME ?>?<?= SEARCH_QUERY_PARAM ?>=<?=  $search_term; ?>&<?= PRODUCT_RESULT_PAGE ?>=<?=  $product_current_page+1; ?>"><?=  $product_current_page+1; ?></a>
      <?php endif; ?>

      <?php if ($product_current_page < $last_page-1) : ?>
      <a class="search-nav search-prev" href="<?=  SEARCH_RESULT_PAGE_NAME ?>?<?= SEARCH_QUERY_PARAM ?>=<?=  $search_term; ?>&<?= PRODUCT_RESULT_PAGE ?>=<?=  $product_current_page+2; ?>"><?=  $product_current_page+2; ?></a>
      <?php endif; ?>

      <?php if ($product_current_page < $last_page-1) : ?>
      <a class="search-nav search-first" href="<?=  SEARCH_RESULT_PAGE_NAME ?>?<?= SEARCH_QUERY_PARAM ?>=<?=  $search_term; ?>&<?= PRODUCT_RESULT_PAGE ?>=<?=  $last_page; ?>">&gt;&gt;</a>
      <?php endif; ?>

    </div>
  </div><!-- search results -->
<?php else: ?>
  <div class="search-result-summary">
    <div class="no-results"><h2>No results found for &quot;<?=  $search_term; ?>&quot;</h2></div>
  </div>
<?php endif; ?>