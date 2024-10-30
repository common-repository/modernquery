<?php

namespace ModernQuery\actions;

use ModernQuery\actions\ActionBase;
use ModernQuery\lib\Settings;

class SettingsAction extends ActionBase {

  public function apply() {

    // add_action('wp_head', [$this, 'renderSettingsScript']);
    // add_action('admin_head', [$this, 'renderSettingsScript']);

    wp_register_script( 'modernquery-settings', '' );
    wp_enqueue_script( 'modernquery-settings' );
    wp_add_inline_script(
      'modernquery-settings',
      'try {
        window.mqSettings = ' . json_encode(Settings::getSettings()) .
      '} catch(e) { console.log(e); }',
      'before'
    );
  }

}