<?php
/**
 *Plugin Name: WP SEO Structured Data Schema
 * Plugin URI: http://kcseopro.com/
 * Description: Comprehensive JSON-LD based Structured Data solution for WordPress for adding schema for organizations, businesses, blog posts, ratings & more.
 * Version: 2.0
 * Author: kcseopro
 * Author URI: http://kcseopro.com/
 * License: A "Slug" license name e.g. GPL2
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if (!defined('JSON_UNESCAPED_SLASHES'))
	define('JSON_UNESCAPED_SLASHES', 64);
if (!defined('JSON_PRETTY_PRINT'))
	define('JSON_PRETTY_PRINT', 128);
if (!defined('JSON_UNESCAPED_UNICODE'))
	define('JSON_UNESCAPED_UNICODE', 256);

define('KCSEO_WP_SCHEMA_SLUG', 'wp-seo-structured-data-schema');
define('KCSEO_WP_SCHEMA_PATH', dirname(__FILE__));
define('KCSEO_WP_SCHEMA_PLUGIN_ACTIVE_FILE_NAME',  plugin_basename( __FILE__ ));
define('KCSEO_WP_SCHEMA_URL', plugins_url('', __FILE__));
define('KCSEO_WP_SCHEMA_LANGUAGE_PATH', dirname( plugin_basename( __FILE__ ) ) . '/languages');

require ('lib/init.php');