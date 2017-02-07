  <div class="col-lg-3 searchBox">
    <form role="search" method="get" id="searchform" class="searchform" action="/search/">
      <input type="text" name="<?php echo SEARCH_QUERY_PARAM; ?>" id="<?php echo SEARCH_QUERY_PARAM; ?>" >
      <input type="submit" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>" class="hide" />
    </form>
  </div>