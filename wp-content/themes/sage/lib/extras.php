<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

//Standard Hart helper functions
/*
 * dump
 *
 * Output object in easy to read format
 *
 */

function dump($obj) {
  echo "<pre>";
  var_dump($obj);
  echo "</pre>";
}

/*
 * isLocalEnvironment
 *
 * Detect if in local environement
 *
 * @return (bool) 
 */
function isLocalEnvironment() {
  return (strrpos($_SERVER['SERVER_NAME'], "devhart") !== -1 && strrpos($_SERVER['SERVER_NAME'], "local") !== -1);
}

/*
 * isDevEnvironment
 *
 * Detect if in development environement
 *
 * @param (bool) $includeLocal if true local environments will be regarded as dev environment
 * @return (bool) 
 */
function isDevEnvironment($includeLocal = false) {
  if ($includeLocal && isLocalEnvironment()) {
    return true;
  }
  return (strrpos($_SERVER['SERVER_NAME'], "devhart.com") !== FALSE);
}

/*
 * social_link
 *
 * outputs target of social media property to be standardized across site
 *
 * @param (string) $prop social property to get target URL
 * 
 */
function social_link($prop) {
  switch ($prop) {
    case "linkedIn":
     echo "https://www.linkedin.com/company/[enter company id]";
      break;
    case "facebook":
      echo "https://www.facebook.com/[enter company facebook id]";
      break;
    case "twitter":
      echo "http://twitter.com/[enter company twitter handle]";
      break;
    case "contactUs":
      echo "/contact-us/";
      break;
  }
}

/*
 * get_ID_by_slug
 *
 * get WP object's ID based on page path/slug
 *
 * @param (string) $page_slug slug of page to get ID for
 * 
 * @return (mixed) null or int Returns page ID if found
 */
function get_ID_by_slug($page_slug) {
  $page = get_page_by_path($page_slug);
  if ($page) {
    return $page->ID;
  } else {
    return null;
  }
}

/*
 * is_external
 *
 * detect if url is an external, for use with links
 *
 * @param (string) $url url of link to check if it is an external link
 * 
 * @return (bool)
 */
function is_external($url) {
  if(strpos($url,$_SERVER['HTTP_HOST']) > -1 || strpos($url,"/") === 0) { 
    return false;
  } 
  return true;    
}

/*
 * new_excerpt_more
 *
 * customize the "Read More" link/text
 *
 * @param (string) $more read more link
 * 
 * @return (string) Returns the link to be displayed
 */
function new_excerpt_more($more) {
  global $post;
  return '<a class="moretag" href="'. get_permalink($post->ID) . '">read more</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

/*
 * register_myplugin_button
 *
 * add 'code' to the tinyMce buttons on the rich editor
 *
 * @param (array) $buttons array of buttons displayed in tinyMCE
 * 
 * @return (array) array of buttons with additional buttons
 */
function register_myplugin_button($buttons) {
   //array_push($buttons, "code"); //adds the source code button
   return $buttons;
}

/*
 * display_field
 *
 * display field from ACF (string or array)
 *
 * @param (mixed) $value array, string or other object to be displayed.
 * 
 */
function display_field($value) {
  if( is_array($value) )
  {
    $value = @implode(', ',$value);
  }
  
  if ( is_string($value)) {
    echo $value;
  } else {
    dump($value);
  }
}

/*
 * custom_excerpt_length
 *
 * change length of excerpt to custom length
 *
 * @param (int) $length length of excerpt to display
 * 
 */
function custom_excerpt_length( $length ) {
  return '/' === $_SERVER['REQUEST_URI'] ? 25 : 55;
}

function get_url_query_var($param, $default_fallback = "") {
  return isset($_GET[$param]) ? $_GET[$param] : $default_fallback;
}