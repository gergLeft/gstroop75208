<?php
/*
 * Template Name: Search Results
 */
?>
<div class="container contentBlock">
  <div class="row">
    <div class="col-lg-12">
      <h1>Search Results</h1>
      <?php $search_term = get_url_query_var(SEARCH_QUERY_PARAM); ?>

      <h2>Searching for "<?php echo $search_term; ?>"...</h2>

      <?php if (ECOMMERCE_ENABLED) : ?>
      <div class="tabbed-result-tabs">
        <div class="product-results-tab tab-selector active">Products</div>
        <div class="site-results-tab tab-selector">Site</div> ?>
        <div class="clearfix"> </div>
      </div>
      <?php endif; ?>

      
      <?php if (ECOMMERCE_ENABLED) : ?>
      <div class="tabbed-result-set">
      <?php endif;?>
        <div class="product-results <?php if (ECOMMERCE_ENABLED && isset($_GET[SEARCH_RESULT_TYPE]) && "1" != $_GET[SEARCH_RESULT_TYPE]) : ?>hide<?php endif; ?>">
          <?php include 'templates/product-search-results.php'; ?>
        </div>

        <?php if (ECOMMERCE_ENABLED) : ?>
        <div class="site-results <?php if (!isset($_GET[SEARCH_RESULT_TYPE]) || "0" != $_GET[SEARCH_RESULT_TYPE]) : ?>hide<?php endif; ?>" >
          <?php include 'templates/site-search-results.php'; ?>
        </div>
        <?php endif; ?>
        
      <?php if (ECOMMERCE_ENABLED) : ?>
      </div>
      <?php endif; ?>
      
    </div>
  </div>
</div>