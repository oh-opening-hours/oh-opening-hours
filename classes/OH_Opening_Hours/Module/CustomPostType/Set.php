<?php

namespace OH_Opening_Hours\Module\CustomPostType;

use OH_Opening_Hours\Module\AbstractModule;

/**
 * Set Custom Post Type
 *
 * @author      Jannik Portz
 * @package     OH_Opening_Hours\Module\CustomPostType
 */
class Set extends AbstractModule {
  const CPT_SLUG = 'op-set';
  const META_BOX_ID = 'op-set-periods';
  const META_BOX_CONTEXT = 'advanced';
  const META_BOX_PRIORITY = 'high';
  const PERIODS_META_KEY = '_opoh_set_periods';
  const TEMPLATE_META_BOX = 'op-set-meta-box.php';
  const NONCE_NAME = 'op-update-set-nonce';
  const NONCE_VALUE = 'op-set-opening-hours';

  const FILTER_POST_TYPE_ARGUMENTS = 'opoh_set_post_type_arguments';

  /**
   * Meta Boxes
   * associative array of MetaBox modules with:
   *  key:      string w/ MetaBox identifier
   *  value:    MetaBox singleton object
   *
   * @var       array
   */
  protected static $metaBoxes;

  /** Constructor */
  public function __construct() {
    $this->registerHookCallbacks();

    static::$metaBoxes = array(
      'OH_Opening_Hours' => MetaBox\OH_Opening_Hours::getInstance(),
      'Holidays' => MetaBox\Holidays::getInstance(),
      'IrregularOpenings' => MetaBox\IrregularOpenings::getInstance(),
      'SetDetails' => MetaBox\SetDetails::getInstance()
    );
  }

  /** Register Hook Callbacks */
  public function registerHookCallbacks() {
    add_action('init', array($this, 'registerPostType'));
    add_action('admin_menu', array($this, 'cleanUpMenu'));
  }

  /** Registers Post Type */
  public function registerPostType() {
    register_post_type(self::CPT_SLUG, $this->getArguments());
  }

  /** Clean Up Menu */
  public function cleanUpMenu() {
    global $submenu;

    /** Top Level: Registered via post_type op-set: Remove "Add New" Item */
    unset($submenu['edit.php?post_type=op-set'][10]);
  }

  /**
   * Getter: Labels
   * @return    array
   */
  public function getLabels() {
    return array(
      'name' => __('Sets', 'oh-opening-hours'),
      'singular_name' => __('Set', 'oh-opening-hours'),
      'menu_name' => __('Opening Hours', 'oh-opening-hours'),
      'name_admin_bar' => __('Set', 'oh-opening-hours'),
      'add_new' => __('Add New', 'oh-opening-hours'),
      'add_new_item' => __('Add New Set', 'oh-opening-hours'),
      'new_item' => __('New Set', 'oh-opening-hours'),
      'edit_item' => __('Edit Set', 'oh-opening-hours'),
      'view_item' => __('View Set', 'oh-opening-hours'),
      'all_items' => __('All Sets', 'oh-opening-hours'),
      'search_items' => __('Search Sets', 'oh-opening-hours'),
      'parent_item_colon' => __('Parent Sets:', 'oh-opening-hours'),
      'not_found' => __('No sets found.', 'oh-opening-hours'),
      'not_found_in_trash' => __('No sets found in Trash.', 'oh-opening-hours')
    );
  }

  /**
   * Getter: Arguments
   * @return    array
   */
  public function getArguments() {
    $arguments = array(
      'labels' => $this->getLabels(),
      'public' => false,
      'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'query_var' => true,
      'capability_type' => 'page',
      'has_archive' => true,
      'hierarchical' => true,
      'menu_position' => 400,
      'menu_icon' => 'dashicons-clock',
      'supports' => array('title', 'page-attributes')
    );

    /**
     * Filter Set custom post type arguments.
     * @param   array    $arguments     The arguments passed to `register_post_type`
     * @return  array                   Filtered arguments passed to `register_post_type`
     */
    return apply_filters(self::FILTER_POST_TYPE_ARGUMENTS, $arguments);
  }
}
