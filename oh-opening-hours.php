<?php
/*
 * Plugin Name: Opening Hours
 * Plugin URI: https://github.com/oh-opening-hours/oh-opening-hours
 * Description: Manage your venue's Opening Hours, Holidays and Irregular Openings in WordPress and display them in many different Widgets and Shortcodes
 * Version: 1.0.0
 * Author: Klaus Kirnbauer
 * Author URI: https://kirnbauer.dev
 * Text Domain: oh-opening-hours
 * Domain Path: /language
 */

if (!defined('ABSPATH')) {
  die('Access denied.');
}
use \YeEasyAdminNotices\V1\AdminNotice;

define('OP_NAME', 'Opening Hours');
define('OP_REQUIRED_PHP_VERSION', '8.0');
define('OP_REQUIRED_WP_VERSION', '6.0');

require_once dirname(__FILE__) . '/includes/admin-notices/AdminNotice.php';

function op_admin_notice_php_version() {
  AdminNotice::create()
    ->warning('Warning')
    ->text(__('Plugin '.OP_NAME.' requires at least PHP Version '.OP_REQUIRED_PHP_VERSION.'. Your Installation of WordPress is currently running on PHP '.PHP_VERSION, 'oh-opening-hours'))
    ->show();
}


function op_admin_notice_wp_version() {
  global $wp_version;
  AdminNotice::create()
    ->warning('Warning')
    ->text(__('Plugin '.OP_NAME.' requires at least WordPress version '.OP_REQUIRED_WP_VERSION.'. Your Installation of WordPress is running on WordPress '.$wp_version, 'oh-opening-hours'))
    ->show();
}


/**
 * Checks if the system requirements are met
 *
 * @return      bool      Whether System requirements are met
 */
function op_requirements() {
  global $wp_version;

  if (version_compare(PHP_VERSION, OP_REQUIRED_PHP_VERSION, '<')) {
    add_action('admin_init', 'op_admin_notice_php');
    return false;
  }

  if (version_compare($wp_version, OP_REQUIRED_WP_VERSION, '<')) {
    add_action('admin_init', 'op_admin_notice_wp');
    return false;
  }

  if(in_array('wp-opening-hours/wp-opening-hours.php', apply_filters('active_plugins', get_option('active_plugins')))){
    deactivate_plugins('wp-opening-hours/wp-opening-hours.php');
    return false;
  }

  return true;
}

/** Returns Plugin Directory Path */
function op_plugin_dir_path() {
  return plugin_dir_path(__FILE__);
}

/**
 * Returns the absolute path of the specified view
 *
 * @param       string $view view path relative to views directory
 *
 * @return      string              absolute path to view
 */
function op_view_dir_path($view) {
  return op_plugin_dir_path() . 'views/' . $view;
}

/** ReturnsBootstrap File Path */
function op_bootstrap_file_path() {
  return __FILE__;
}

/**
 * Autoloader for Plugin classes
 *
 * @param       string $className Name of the class that shall be loaded
 */
function op_autoloader($className) {
  $filepath = op_plugin_dir_path() . 'classes/' . str_replace('\\', '/', $className) . '.php';

  if (file_exists($filepath)) {
    require_once $filepath;
  }
}

spl_autoload_register('op_autoloader');

/**
 * Check requirements and load main class
 * The main program needs to be in a separate file that only gets loaded if the plugin requirements are met. Otherwise
 * older PHP installations could crash when trying to parse it.
 */
if (op_requirements()) {
  require_once 'run.php';
}
