<?php

namespace ModernQuery\Actions;

class ActionDispatcher {

  /**
   * Actions that have to fire on init, even before
   * current post is available
  */
  public static function getEarlyActions() {

    return [
    ];

  }

  public static function getActions() {

    return [
      new \ModernQuery\actions\SettingsAction(),
      new \ModernQuery\actions\PostSaveAction(),
      new \ModernQuery\actions\SearchResultsAction(),
      new \ModernQuery\actions\SearchAutocompleteAction(),
      new \ModernQuery\actions\PostMetaAction(),
      new \ModernQuery\actions\ChatShortcodeAction()
    ];

  }

  public static function dispatch() {
    
    foreach (static::getActions() as $action) {
      $action->apply();
    }
  }

}