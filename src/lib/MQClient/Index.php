<?php

namespace ModernQuery\lib\MQClient;

use ModernQuery\lib\MQClient\Request;
use GuzzleHttp\RequestOptions;

class Index extends Request {

  public $url;

  public function setUrl($url) {
    $this->url = $url;
  }

  public function send($params = []) {

    return parent::send(
      [
        'endpoint' => 'document/index',
        'request_method' => 'PUT',
        RequestOptions::HEADERS => ['Accept' => 'application/json', "Content-Type" => "application/json"],
        RequestOptions::JSON => [
          'domain' => $this->domain_name,
          'key' => $this->property_key,
          'url' => $this->url,
        ]
      ]
    );

  }

}