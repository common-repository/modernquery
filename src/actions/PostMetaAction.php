<?php

namespace ModernQuery\actions;

use ModernQuery\actions\ActionBase;
use ModernQuery\lib\Settings;

class PostMetaAction extends ActionBase {

  public function apply() {

    add_action('wp_head', [$this, 'addPostIdTag']);
  }

  public function addPostIdTag() {

    if (is_single()) {
      $post_id = get_the_ID();
      echo "\n" . '<meta property="mq:source_id" content="' . esc_attr($post_id) . '">' . "\n";
    }

  }

  public function addBoostTag() {

    $boosted_field_name = get_option('modernquery_boost_field_name', 'boosted_keywords');

    if (is_singular()) {
      $post_id = get_the_ID();
      $boosted_val = null;

      if (get_post($post_id)) {
        
        if (function_exists('get_field')) {
          $boosted_val = get_field($boosted_field_name, $post_id, false);
        }

        if (!$boosted_val) {
          $boosted_val = get_post_custom_values($boosted_field_name, $post_id);
        }

        if ($boosted_val) {
          echo "\n" . '<meta property="mq:boost" content="' . esc_attr($boosted_val) . '">' . "\n";
        }

      }
    }

  }
}