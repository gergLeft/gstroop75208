<?php

namespace Roots\Sage\Assets;

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
  //wp_enqueue_style( 'style-name', get_stylesheet_directory_uri() . '/dist/styles/script-file-name.css' );
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );
function theme_enqueue_scripts() {
  //wp_enqueue_script( 'script-name', get_stylesheet_directory_uri() . '/dist/scripts/script-file-name.js', array(), '1.0.0', true );
}

/**
 * Get paths for assets
 */
class JsonManifest {
  private $manifest;

  public function __construct($manifest_path) {
    if (file_exists($manifest_path)) {
      $this->manifest = json_decode(file_get_contents($manifest_path), true);
    } else {
      $this->manifest = [];
    }
  }

  public function get() {
    return $this->manifest;
  }

  public function getPath($key = '', $default = null) {
    $collection = $this->manifest;
    if (is_null($key)) {
      return $collection;
    }
    if (isset($collection[$key])) {
      return $collection[$key];
    }
    foreach (explode('.', $key) as $segment) {
      if (!isset($collection[$segment])) {
        return $default;
      } else {
        $collection = $collection[$segment];
      }
    }
    return $collection;
  }
}

function asset_path($filename) {
  $dist_path = get_template_directory_uri() . '/dist/';
  $directory = dirname($filename) . '/';
  $file = basename($filename);
  static $manifest;

  if (empty($manifest)) {
    $manifest_path = get_template_directory() . '/dist/' . 'assets.json';
    $manifest = new JsonManifest($manifest_path);
  }

  if (array_key_exists($file, $manifest->get())) {
    return $dist_path . $directory . $manifest->get()[$file];
  } else {
    return $dist_path . $directory . $file;
  }
}
