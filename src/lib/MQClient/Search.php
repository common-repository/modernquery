<?php

namespace ModernQuery\lib\MQClient;

use ModernQuery\lib\MQClient\Request;
use GuzzleHttp\RequestOptions;

class Search extends Request {

  public $keywords;
  public $result_count = 10;
  public $results_per_page = 10;
  public $page = 1;

  public function __construct() {

  }

  public function setKeywords($keywords) {
    $this->keywords = $keywords;
  }

  // public function setResultCount($count) {
  //   $this->result_count = (int) $count;
  // }

  public function setResultsPerPage($per_page) {
    $this->results_per_page = $per_page;
  }

  public function setPage($page) {
    $this->page = $page;
  }

  public function send($params = array()) {
   
    return parent::send(
      [
        'endpoint' => 'document/search',
        RequestOptions::QUERY => [
          'domain' => $this->domain_name,
          'keywords' => $this->keywords,
          'results_per_page' => $this->results_per_page,
          'page' => $this->page
        ]
      ]
    );
  }

  public function search() {
    return $this->send();
  }

}