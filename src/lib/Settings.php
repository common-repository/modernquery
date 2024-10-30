<?php

namespace ModernQuery\lib;

class Settings {

  static $settings_fields = [
    'modernquery_domain_name' => ['name' => 'modernquery_domain_name', 'default_value' => ''],
    'modernquery_search_input_selector' => ['name' => 'modernquery_search_input_selector', 'default_value' => 'input[name="s"][type="search"]'],
    'modernquery_property_key' => ['name' => 'modernquery_property_key', 'default_value' => '']
  ];

  public static function getSettings() {

    $settings = [];

    foreach(static::$settings_fields as $setting_key => $setting_info) {
      $settings[$setting_info['name']] = get_option($setting_info['name'], $setting_info['default_value']);
    }

    return $settings;

  }
}

