<?php

namespace ModernQuery\lib\util\url;

class UrlUtil {

  public static function stripScheme($url) {
    return preg_replace('/^https?:\/\//i', '', trim($url));
  }

  public static function addSchemeIfMissing($url, $scheme = 'https://') {
    return $scheme . UrlUtil::stripScheme($url);
  }

  public static function stripTrailingSlash($url) {
    return preg_replace('/\/+$/', '', trim($url));
  }

  public static function extractRelativePath($url) {

    $parsed_url = UrlUtil::stripScheme($url);
    $parsed_url = UrlUtil::stripTrailingSlash($parsed_url);

    if (strpos($parsed_url, '/') !== false) {
      return strstr($parsed_url, '/');
    }

    return '/';
  }

  public static function extractDomainName($url) {
    
    $parsed_url = trim($url);
    $parsed_url = UrlUtil::stripScheme($parsed_url);

    if (strpos($parsed_url, '/') !== false) {
      return substr($parsed_url, 0, strpos($parsed_url, '/'));
    }

    return $parsed_url;

  }

}