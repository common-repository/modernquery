<?php

/**
 * ModernQuery
 *
 * @package ModernQuery
 * @author James Keller
 *
 * Plugin Name:       ModernQuery
 * Description:       Integrate search with the ModernQuery Platform
 * Requires at least: 5.6
 * Requires PHP:      7.0
 * Version:           1.0.3
 * Author:            ModernQuery
 * Text Domain:       modern_query
 * Author URI:        https://www.modernquery.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package           modernquery
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require __DIR__ . '/vendor/autoload.php';

/* Initialize Global Post Actions */
//\ModernQuery\post\PostActions::initialize();

/* Dispatch Actions */
add_action('init', function() {

  \ModernQuery\actions\ActionDispatcher::dispatch();
  
});


add_action('admin_menu', function() {

  \ModernQuery\admin\AdminPage::init();
});

/*
add_action( 'init',  function() {

  $actions = \WPSubsite\actions\ActionDispatcher::getEarlyActions();

  foreach($actions as $action) {
    $action->apply();
  }

} );
*/


