<?php

namespace ModernQuery\actions;

use ModernQuery\actions\ActionBase;
use ModernQuery\lib\results\ResultsData;
use ModernQuery\lib\Constants;

class SearchResultsAction extends ActionBase {

  public const RESULTS_PER_PAGE_DEFAULT = 10;

  public static $TemplateFilenameBase = 'mq-search-results';
  
  public $isSearchPage = false;

  public function apply() {
    
    //add_action('pre_get_posts', [$this, 'doPreGetPostsActions'], 1);
    add_filter('posts_pre_query', [$this, 'doPreQueryActions']);

  }

  public function doPreQueryActions() {

    if ($this->isSearchPage()) {

      $params = [];

      if (is_numeric(get_query_var('page'))) {
        $params['page'] = get_query_var('page');
      }

      $params['per_page'] = static::RESULTS_PER_PAGE_DEFAULT;

      $keywords = get_search_query();

      $this->cancelDefaultSearch();
      $this->performSearch($keywords, $params);

      add_filter('template_include', [$this, 'applyCustomResultsTemplate']);
    }

  }

  public function isSearchPage() {

    global $wp_query;

    return $this->isSearchPage || (is_search() && $wp_query->is_main_query());
  }

  public function cancelDefaultSearch() {

    global $wp_query;

    $wp_query->set('post__in', ['INVALID-ID-SET-BY-MODERNQUERY-TO-CANCEL-QUERY']);

  }

  public function performSearch($keywords = null, $params = []) {

    if (!($domain_name = get_option('modernquery_domain_name'))) {
      throw new \Exception("Please specify a domain name in the ModernQuery settings");
    }

    $search_client = new \ModernQuery\lib\MQClient\Search;
    $search_client->setKeywords($keywords);
    $search_client->setDomainName($domain_name);

    if (!empty($params['page']) && is_numeric($params['page'])) {
      $search_client->setPage($params['page']);
    }

    if (!empty($params['per_page']) && is_numeric($params['per_page'])) {
      $search_client->setResultsPerPage($params['per_page']);
    }


    $response = $search_client->search();

    \ModernQuery\lib\results\ResultsData::$raw = $response;
    \ModernQuery\lib\results\ResultsData::$search_string = $keywords;

  }

  public function applyCustomResultsTemplate() {

    $theme_template = locate_template([
      static::$TemplateFilenameBase . '.php',
      static::$TemplateFilenameBase . '.html'
    ]);

    if ($theme_template) {
      return $theme_template;
    }
    else {
      // Set the path to the plugin's template file
      $plugin_template = WP_PLUGIN_DIR
                          . DIRECTORY_SEPARATOR
                          . Constants::PLUGIN_NAME_INTERNAL
                          . DIRECTORY_SEPARATOR
                          . 'templates'
                          . DIRECTORY_SEPARATOR
                          . static::$TemplateFilenameBase;

      if (wp_is_block_theme()) {
        if (is_readable($plugin_template . '.html')) {
          return $plugin_template . '.html';
        }
      }

      if (is_readable($plugin_template . '.php')) {
        return $plugin_template . '.php';
      }

    }

  }
}