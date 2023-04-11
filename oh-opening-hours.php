<?php
/*
 * Plugin Name: O/H - Opening Hours
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

define('OPOH_NAME', 'Opening Hours');
define('OPOH_MIN_PHP_VERSION', '8.1');
define('OPOH_MIN_WP_VERSION', '6.0');
define('OPOH_PLUGIN_ROOT', plugin_dir_path( __FILE__ ));
define('OPOH_PLUGIN_ABSOLUTE', __FILE__ );


function opoh_admin_notice_php_version() {
  $class = 'notice notice-warning';
	$message = __( 'Plugin '.OPOH_NAME.' requires at least PHP Version '.OPOH_MIN_PHP_VERSION.'. Your Installation of WordPress is currently running on PHP '.PHP_VERSION, 'oh-opening-hours' );
	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}


function opoh_admin_notice_wp_version() {
  global $wp_version;
  $class = 'notice notice-warning';
	$message = __( 'Plugin '.OPOH_NAME.' requires at least WordPress version '.OPOH_MIN_WP_VERSION.'. Your Installation of WordPress is running on WordPress '.$wp_version, 'oh-opening-hours' );
	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}


/**
 * Checks if the system requirements are met
 *
 * @return      bool      Whether System requirements are met
 */
function opoh_requirements() {
  global $wp_version;

  if (version_compare(PHP_VERSION, OPOH_MIN_PHP_VERSION, '<')) {
    add_action('admin_notices', 'opoh_admin_notice_php_version');
    return false;
  }

  if (version_compare($wp_version, OPOH_MIN_WP_VERSION, '<')) {
    add_action('admin_notices', 'opoh_admin_notice_wp_version');
    return false;
  }

  if(in_array('wp-opening-hours/wp-opening-hours.php', apply_filters('active_plugins', get_option('active_plugins')))){
    deactivate_plugins('wp-opening-hours/wp-opening-hours.php');
    return false;
  }

  return true;
}

/** Returns Plugin Directory Path */
function opoh_plugin_dir_path() {
  return plugin_dir_path(__FILE__);
}

/**
 * Returns the absolute path of the specified view
 *
 * @param       string $view view path relative to views directory
 *
 * @return      string              absolute path to view
 */
function opoh_view_dir_path($view) {
  return opoh_plugin_dir_path() . 'views/' . $view;
}

/** ReturnsBootstrap File Path */
function opoh_bootstrap_file_path() {
  return __FILE__;
}

/**
 * Autoloader for Plugin classes
 *
 * @param       string $className Name of the class that shall be loaded
 */
function opoh_autoloader($className) {
  $filepath = opoh_plugin_dir_path() . 'classes/' . str_replace('\\', '/', $className) . '.php';

  if (file_exists($filepath)) {
    require_once $filepath;
  }
}

spl_autoload_register('opoh_autoloader');

/**
 * Check requirements and load main class
 * The main program needs to be in a separate file that only gets loaded if the plugin requirements are met. Otherwise
 * older PHP installations could crash when trying to parse it.
 */
if (opoh_requirements()) {
  require_once 'run.php';
}
