<?php

namespace ModernQuery\lib\MQClient;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class Request {

  public const ENDPOINT_BASE_URL = 'https://api.modernquery.io';
  public const REQUEST_METHOD_DEFAULT = 'GET';
  
  public $domain_name;
  public $property_key;

  public function setDomainName($domain_name) {
    $this->domain_name = $domain_name;
  }

  public function setPropertyKey($key) {
    $this->property_key = $key;
  }

  public function getDefaultParams() {
    return [
      RequestOptions::HEADERS => ['Accept' => 'application/json'],
      RequestOptions::TIMEOUT => 3
    ];
  } 
  
  
  public function send($params = []) {

    $client = new Client();

    $params = array_merge($params, $this->getDefaultParams());
    $url = rtrim(static::ENDPOINT_BASE_URL, '/') . '/' . ltrim($params['endpoint'], '/');

    $request_method = (!empty($params['request_method'])) ? strtoupper($params['request_method']) : static::REQUEST_METHOD_DEFAULT;

    $response = $client->request(
      $request_method,
      $url,
      $params
    );

    $status_code = $response->getStatusCode();

    // Handle the response based on the status code
    if ($status_code === 200) {
      // Get the response body
      return json_decode($response->getBody(), true);
    }


    return null;

  }

}
