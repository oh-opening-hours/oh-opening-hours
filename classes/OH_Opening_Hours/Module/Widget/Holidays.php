<?php

namespace OH_Opening_Hours\Module\Widget;

use OH_Opening_Hours\Module\OH_Opening_Hours;
use OH_Opening_Hours\Module\Shortcode\Holidays as HolidaysShortcode;

/**
 * Widget for Holiday Shortcode
 *
 * @author      Jannik Portz
 * @package     OH_Opening_Hours\Module\Widget
 */
class Holidays extends AbstractWidget {
  public function __construct() {
    $title = __('Opening Hours: Holidays', 'oh-opening-hours');
    $description = __('Lists up all Holidays in the selected Set.', 'oh-opening-hours');
    parent::__construct('widget_opoh_holidays', $title, $description, HolidaysShortcode::getInstance());
  }

  /** @inheritdoc */
  protected function registerFields() {
    // Standard Fields
    $this->addField('title', array(
      'type' => 'text',
      'caption' => __('Title', 'oh-opening-hours')
    ));

    $this->addField('set_id', array(
      'type' => 'select',
      'caption' => __('Set', 'oh-opening-hours'),
      'options_callback' => array(OH_Opening_Hours::getInstance(), 'getSetsOptions')
    ));

    $this->addField('highlight', array(
      'type' => 'checkbox',
      'caption' => __('Highlight active Holiday', 'oh-opening-hours')
    ));

    $this->addField('template', array(
      'type' => 'select',
      'caption' => __('Template', 'oh-opening-hours'),
      'options' => array(
        'table' => __('Table', 'oh-opening-hours'),
        'list' => __('List', 'oh-opening-hours')
      )
    ));

    $this->addField('include_past', array(
      'type' => 'checkbox',
      'caption' => __('Include past holidays', 'oh-opening-hours')
    ));

    // Extended Fields
    $this->addField('class_holiday', array(
      'type' => 'text',
      'caption' => __('Holiday &lt;tr&gt; class', 'oh-opening-hours'),
      'extended' => true,
      'default_placeholder' => true
    ));

    $this->addField('class_highlighted', array(
      'type' => 'text',
      'caption' => __('class for highlighted Holiday', 'oh-opening-hours'),
      'extended' => true,
      'default_placeholder' => true
    ));

    $this->addField('date_format', array(
      'type' => 'text',
      'caption' => __('PHP Date Format', 'oh-opening-hours'),
      'extended' => true,
      'description' => self::getPhpDateFormatInfo(),
      'default_placeholder' => true
    ));
  }
}
