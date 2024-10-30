<?php

namespace ModernQuery\lib\results;

class ResultsRenderer {

  public static $results_per_page = 10;

  public static function getCurrentPage() {
    return !empty(get_query_var('page')) && is_numeric(get_query_var('page')) ? get_query_var('page') : 1;
  }

  public static function getCurrentUrl() {
    
    global $wp;
    
    $query_args = $wp->query_vars;
    unset($query_args['page']);

    return home_url(add_query_arg($query_args, $wp->request));
  }


  public static function getPagination($options = []) {

    $total = \ModernQuery\lib\results\ResultsData::getTotalResultsCount();
    $qs_prefix = (empty($_GET)) ? '?' : '&';

    if (!is_numeric($total)) {
      $total = 0;
    }

    return paginate_links(
      array_merge(
        [
          'base' => static::getCurrentUrl() . $qs_prefix . 'page=%_%',
          'format' => '%#%',
          'current' => static::getCurrentPage(),
          'total' => ceil($total / static::$results_per_page)
        ],
        $options
      )
    );
  
  }

}