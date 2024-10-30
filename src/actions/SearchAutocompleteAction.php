<?php

namespace ModernQuery\actions;

use ModernQuery\actions\ActionBase;

class SearchAutocompleteAction extends ActionBase {

  public function apply() {

    $css_url = plugin_dir_url(__FILE__) . 'css/search_autocomplete.css';
    $css_path = plugin_dir_path(__FILE__) . 'css/search_autocomplete.css';

    wp_enqueue_style(
      'modernquery-autocomplete',
      $css_url,
      array(),
      filemtime($css_path),
      'all' );

    wp_enqueue_script(
      'modernquery-autocomplete-library',
      plugin_dir_url(__FILE__) . 'js/vendor/autoComplete.min.js',
      ['modernquery-settings']
    );

    wp_enqueue_script(
      'modernquery-autocomplete',
      plugin_dir_url(__FILE__) . 'js/SearchAutocomplete.js',
      ['modernquery-settings', 'modernquery-autocomplete-library']
    );
    
  }

 
}