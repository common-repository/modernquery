<?php

namespace ModernQuery\actions;

use ModernQuery\actions\ActionBase;
use ModernQuery\lib\Settings;
use ModernQuery\lib\MQClient\Crawl;
use ModernQuery\lib\MQClient\Index;
use ModernQuery\lib\exceptions\InvalidSettingsException;
use ModernQuery\lib\util\url\UrlUtil;

class PostSaveAction extends ActionBase {

  protected $messages = [];

  public function apply() {

    add_action('save_post', [$this, 'run']);
    add_action('admin_notices', [$this, 'displayMessages']);
  }

  public function run($post_id) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return;
    }

    if ( !current_user_can('edit_post', $post_id) ) {
      return;
    }

    try {

      if (!defined('MODERNQUERY_CRAWL_INITIATED')) {
        define('MODERNQUERY_CRAWL_INITIATED', true);
        return $this->reCrawlAndReindexPost($post_id);
      }

    }
    catch(\Exception $e) {

      $this->messages[] = 'Could not crawl and re-index post for site search';
      $this->messages[] = $e->getMessage();
    }
  }

  public function displayMessages() {

    if (count($this->messages) > 0) {
      echo "<div class=\"notice notice-error\"><p>" . wp_kses_post(join('<br>', $this->messages)) . '</p></div>';
    }

  }

  public function reCrawlAndReindexPost($post_id) {

    $permalink = get_permalink($post_id);

    $settings = Settings::getSettings();

    if (empty($settings['modernquery_domain_name'])) {
      throw new InvalidSettingsException('Domain name not configured');
    }

    if (empty($settings['modernquery_property_key'])) {
      throw new InvalidSettingsException('Property key not configured');
    }

    $post_domain = UrlUtil::extractDomainName($permalink);
    $post_relative_url = UrlUtil::extractRelativePath($permalink);
    $settings_domain = UrlUtil::extractDomainName($settings['modernquery_domain_name']);

    if (!defined('MODERNQUERY_ALLOW_MISMATCHED_DOMAINS') || !constant('MODERNQUERY_ALLOW_MISMATCHED_DOMAINS')) {
      if ($post_domain != $settings_domain) {
        throw new \InvalidArgumentException('You are editing from a different domain than what is configured in your search settings. Post was not reindexed.');
      }
    }

    if (defined('MODERNQUERY_FORCE_DOMAIN_REWRITE') && constant('MODERNQUERY_FORCE_DOMAIN_REWRITE')) {
      $permalink = "https://{$settings_domain}{$post_relative_url}";
    }

    $crawl = new Crawl();
    $crawl->setUrl($permalink);
    $crawl->setDomainName($settings['modernquery_domain_name']);
    $crawl->setPropertyKey($settings['modernquery_property_key']);

    $response = $crawl->send();

    if ($response) {
      $index = new Index();
      $index->setUrl($permalink);
      $index->setDomainName($settings['modernquery_domain_name']);
      $index->setPropertyKey($settings['modernquery_property_key']);

      $response = $index->send();

      if ($response) {
        //show_message('Post re-crawled and re-indexed successfully');
      }
      else {
        throw new \Exception('There was an error indexing that post. The latest content may not appear in your site search');
      } 
    }
    else {
      throw new \Exception('There was an error re-crawling that post for the search indexer.');
    }

    return $permalink;


  }

 
}