<?php

namespace ModernQuery\lib\results;

class ResultsData {

  static $raw = [];
  static $search_string = '';

  public static function getItemsRaw() {

    if (!empty(static::$raw['hits'])) {
      return static::$raw['hits'];
    }

    return null;

  }

  public static function getItems() {

    if (!empty(static::$raw['hits']['hits'])) {
      return array_map(
        function ($hit) {

          $highlight = !empty($hit['highlight']) ? $hit['highlight'] : '';

          return [
            'fields' => static::formatFields($hit),
            'highlights' => static::formatHighlights($highlight)
          ];

        },
        static::$raw['hits']['hits']
      );
    }

    return null;

  }

  public static function formatHighlights($highlights_raw) {

    if ($highlights_raw) {

      return array_map(
        function($highlight) {

          $highlight = array_unique($highlight);
          $highlight = array_filter(
            $highlight, function($val) {
              return preg_match('/\s+/', $val);
            }
          );
          return join('...', $highlight);
        },
        $highlights_raw
      );
    }

    return '';

  }

  public static function formatFields($hit) {

    return [
      'id' => $hit['_source']['id'],
      'source_id' => $hit['_source']['source_id'],
      'meta' => $hit['_source']['meta'],
      'title' => $hit['_source']['title'],
      'url' => $hit['_source']['url'],
      'image_url' => static::getImageUrlFromHit($hit)
    ];

  }

  public static function getImageUrlFromHit($hit) {

    if (!empty($hit['_source']['meta']) && is_array($hit['_source']['meta'])) {
      foreach ($hit['_source']['meta'] as $meta_data) {
        if ($meta_data['key'] == 'og:image') {
          return $meta_data['value'];
        }
      }
    }

    return null;
  }

  public static function getTotalResultsCount() {

    if (!empty(static::$raw['hits'])) {
      return static::$raw['hits']['total']['value'];
    }

    return null;

  }

}
