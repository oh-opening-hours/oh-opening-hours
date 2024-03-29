<?php

namespace OH_Opening_Hours;

use OH_Opening_Hours\Module as Module;
use OH_Opening_Hours\Module\AbstractModule;
use OH_Opening_Hours\Module\Widget\AbstractWidget;
use OH_Opening_Hours\Util\Dates;
use OH_Opening_Hours\Util\Weekdays;

/**
 * Core Module for the Opening Hours Plugin
 *
 * @author      Jannik Portz
 * @package     OH_Opening_Hours
 */
class OH_Opening_Hours extends AbstractModule {
  const FILTER_USE_FRONT_END_STYLES = 'opoh_use_front_end_styles';

  /**
   * Collection of all plugin modules
   * @var       AbstractModule[]
   */
  protected $modules;

  /**
   * Collection of all plugin widgets
   * @var       AbstractWidget[]
   */
  protected $widgets;

  /** The plugin version */
  const VERSION = '1.0.0';

  /** The Plugin DB version */
  const DB_VERSION = '2';

  /** The plugin prefix */
  const PREFIX = 'opoh_';

  /** Constructor for OH_Opening_Hours module */
  protected function __construct() {
    $this->registerHookCallbacks();

    $this->modules = array(
      'OH_Opening_Hours' => Module\OH_Opening_Hours::getInstance(),
      'I18n' => Module\I18n::getInstance(),
      'Ajax' => Module\Ajax::getInstance(),
      'CustomPostType\Set' => Module\CustomPostType\Set::getInstance(),
      'Shortcode\IsOpen' => Module\Shortcode\IsOpen::getInstance(),
      'Shortcode\Overview' => Module\Shortcode\Overview::getInstance(),
      'Shortcode\Holidays' => Module\Shortcode\Holidays::getInstance(),
      'Shortcode\IrregularOpenings' => Module\Shortcode\IrregularOpenings::getInstance(),
      'Shortcode\Schema' => Module\Shortcode\Schema::getInstance()
    );

    $this->widgets = array(
      'OH_Opening_Hours\Module\Widget\Overview',
      'OH_Opening_Hours\Module\Widget\IsOpen',
      'OH_Opening_Hours\Module\Widget\Holidays',
      'OH_Opening_Hours\Module\Widget\IrregularOpenings',
      'OH_Opening_Hours\Module\Widget\Schema'
    );
  }

  /** Registers callbacks for actions and filters */
  public function registerHookCallbacks() {
    add_action('wp_enqueue_scripts', array($this, 'loadResources'));
    add_action('admin_enqueue_scripts', array($this, 'loadResources'));

    add_action('widgets_init', array($this, 'registerWidgets'));
    add_action('wp_loaded', array($this, 'maybeUpdate'));
  }

  public function maybeUpdate() {
    $dbVersion = get_option('opening_hours_db_version', false);

    if ($dbVersion === false) {
      Module\Importer::getInstance()->import();
      add_option('opening_hours_db_version', self::DB_VERSION);
    } elseif ((string) $dbVersion !== self::DB_VERSION) {
      update_option('opening_hours_db_version', self::DB_VERSION);
    }

    $version = get_option('opening_hours_version');
    if ($version === false) {
      add_option('opening_hours_version', self::VERSION);
    } elseif ($version !== self::VERSION) {
      update_option('opening_hours_version', self::VERSION);
    }
  }

  /** Registers all plugin widgets */
  public function registerWidgets() {
    foreach ($this->widgets as $widgetClass) {
      $widgetClass::registerWidget();
    }
  }

  public function loadResources() {
    wp_register_style(self::PREFIX . 'frontendcss', plugins_url('dist/styles/main.css', opoh_bootstrap_file_path()));

    $useFrontEndStyles = apply_filters(self::FILTER_USE_FRONT_END_STYLES, true);

    if ($useFrontEndStyles) {
      wp_enqueue_style(self::PREFIX . 'frontendcss');
    }

    if (is_admin() && function_exists('get_current_screen')) {
      $screen = get_current_screen();

      if (
        $screen &&
        (($screen->base === 'post' && $screen->post_type === Module\CustomPostType\Set::CPT_SLUG) ||
          ($screen->base === 'edit' && $screen->post_type === Module\CustomPostType\Set::CPT_SLUG) ||
          $screen->base === 'widgets')
      ) {
        wp_register_style(self::PREFIX . 'backendcss', plugins_url('dist/admin/styles/main.css', opoh_bootstrap_file_path()));
        wp_enqueue_style(self::PREFIX . 'backendcss');

        wp_register_script(
          self::PREFIX . 'js',
          plugins_url('dist/scripts/main.js', opoh_bootstrap_file_path()),
          array('jquery', 'jquery-ui-core'),
          self::VERSION,
          true
        );

        Module\Ajax::injectAjaxUrl(self::PREFIX . 'js');
        wp_localize_script(self::PREFIX . 'js', 'openingHoursData', array(
          'startOfWeek' => (int) Dates::getStartOfWeek(),
          'weekdays' => Weekdays::getDatePickerTranslations(),
          'translations' => array(
            'moreSettings' => __('More Settings', 'oh-opening-hours'),
            'fewerSettings' => __('Fewer Settings', 'oh-opening-hours')
          )
        ));

        wp_enqueue_script(self::PREFIX . 'js');
      }
    }
  }
}
