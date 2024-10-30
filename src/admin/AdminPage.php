<?php

namespace ModernQuery\admin;

use ModernQuery\lib\Constants;

class AdminPage {

  static $page_title = 'ModernQuery settings';
  static $menu_title = 'ModernQuery';
  static $capability = 'manage_options';
  static $menu_slug = 'modernquery';

  public static function init() {

    add_menu_page(
      static::$page_title,
      static::$menu_title,
      static::$capability,
      static::$menu_slug,
      ['\ModernQuery\admin\AdminPage', 'renderPageContents'],
      null,
      null
    );

    add_settings_section(
      'modernquery_main_settings',
      __( 'Custom settings', 'modernquery' ),
      null,
      'modernquery'
    );

    
    add_settings_field(
      'modernquery_domain_name',
      __( 'Domain Name', 'modernquery' ),
      ['\ModernQuery\admin\AdminPage', 'domainNameFieldMarkup'],
      'modernquery',
      'modernquery_main_settings'
   );

   add_settings_field(
    'modernquery_property_key',
    __( 'Property Key', 'modernquery' ),
    ['\ModernQuery\admin\AdminPage', 'propertyKeyFieldMarkup'],
    'modernquery',
    'modernquery_main_settings'
 );

   add_settings_field(
    'modernquery_search_input_selector',
    __( 'Search Input Selector (for autocomplete)', 'modernquery' ),
    ['\ModernQuery\admin\AdminPage', 'searchInputSelectorFieldMarkup'],
    'modernquery',
    'modernquery_main_settings'
 );

   register_setting( 'modernquery', 'modernquery_domain_name' );
   register_setting( 'modernquery', 'modernquery_property_key' );
   register_setting( 'modernquery', 'modernquery_search_input_selector' );

  }

  public static function domainNameFieldMarkup() {

    /* @TODO put this in a template or something because echoing markup inside a function is gross. */

    $value = \get_option('modernquery_domain_name', '');

    echo '
      <input type="text" id="modernquery_domain_name" name="modernquery_domain_name" value="' . \esc_html($value) . '">';

  }

  public static function searchInputSelectorFieldMarkup() {

    /* @TODO put this in a template or something because echoing markup inside a function is gross. */

    $value = \get_option('modernquery_search_input_selector', 'input[name="s"]');

    echo '
      <input type="text" id="modernquery_search_input_selector" name="modernquery_search_input_selector" value="' . \esc_html($value) . '">';

  }

  public static function propertyKeyFieldMarkup() {

    $value = \get_option('modernquery_property_key', '');

    echo '
      <input type="text" id="modernquery_property_key" name="modernquery_property_key" value="' . \esc_html($value) . '">';

  }

  public static function renderPageContents() {

    include WP_PLUGIN_DIR
    . DIRECTORY_SEPARATOR
    . Constants::PLUGIN_NAME_INTERNAL
    . DIRECTORY_SEPARATOR
    . 'templates'
    . DIRECTORY_SEPARATOR
    . 'admin'
    . DIRECTORY_SEPARATOR
    . 'settings-form.php';

    
  }

}