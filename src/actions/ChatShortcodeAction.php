<?php

namespace ModernQuery\actions;

use ModernQuery\actions\ActionBase;
use ModernQuery\lib\Constants;

class ChatShortcodeAction extends ActionBase {

  static $TemplateFilenameBase = 'mq-chat-form';

  public function apply() {

    $css_url = plugin_dir_url(__FILE__) . 'css/chat_form.css';
    $css_path = plugin_dir_path(__FILE__) . 'css/chat_form.css';

    wp_enqueue_style(
      'modernquery-chatform',
      $css_url,
      array(),
      filemtime($css_path),
      'all' );

    wp_enqueue_script(
      'modernquery-chatform',
      plugin_dir_url(__FILE__) . 'js/ChatForm.js',
      ['modernquery-settings']
    );
   
    add_shortcode('modernquery_chat', [$this, 'renderForm']);

  }

  public function getTemplatePath() {

    $theme_template = locate_template([
      static::$TemplateFilenameBase . '.php',
      static::$TemplateFilenameBase . '.html'
    ]);

    if ($theme_template) {
      return $theme_template;
    }
    
    // Set the path to the plugin's template file
    return WP_PLUGIN_DIR
              . DIRECTORY_SEPARATOR
              . Constants::PLUGIN_NAME_INTERNAL
              . DIRECTORY_SEPARATOR
              . 'templates'
              . DIRECTORY_SEPARATOR
              . static::$TemplateFilenameBase
              . '.php';

  }

  public function getFormMarkup() {

    $template_path = $this->getTemplatePath();

    if (!is_readable($template_path)) {
      throw new \Exception ("Template path not readable: " . $template_path);
    }

    ob_start();
    include($template_path);
    return ob_get_clean();

  }

  public function renderForm() {

    print wp_kses(
      $this->getFormMarkup(),
      Constants::FORM_RENDERER_ALLOWED_HTML
    );

  }

 
}