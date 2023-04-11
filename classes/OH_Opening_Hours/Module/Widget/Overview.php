<?php

namespace OH_Opening_Hours\Module\Widget;

use OH_Opening_Hours\Module\OH_Opening_Hours;
use OH_Opening_Hours\Module\Shortcode\Overview as OverviewShortcode;

/**
 * Widget for Overview Shortcode
 *
 * @author      Jannik Portz
 * @package     OH_Opening_Hours\Module\Widget
 */
class Overview extends AbstractWidget {
  public function __construct() {
    $title = __('Opening Hours: Overview', 'oh-opening-hours');
    $description = __(
      'Displays a Table with your Opening Hours. Alternatively use the op-overview Shortcode.',
      'oh-opening-hours'
    );
    parent::__construct('widget_opoh_overview', $title, $description, OverviewShortcode::getInstance());
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
      'caption' => __('Set to show', 'oh-opening-hours'),
      'options_callback' => array(OH_Opening_Hours::getInstance(), 'getSetsOptions')
    ));

    $this->addField('highlight', array(
      'type' => 'select',
      'caption' => __('Highlight', 'oh-opening-hours'),
      'options' => array(
        'nothing' => __('Nothing', 'oh-opening-hours'),
        'period' => __('Running Period', 'oh-opening-hours'),
        'day' => __('Current Weekday', 'oh-opening-hours')
      )
    ));

    $this->addField('show_closed_days', array(
      'type' => 'checkbox',
      'caption' => __('Show closed days', 'oh-opening-hours')
    ));

    $this->addField('show_description', array(
      'type' => 'checkbox',
      'caption' => __('Show Set Description', 'oh-opening-hours')
    ));

    $this->addField('compress', array(
      'type' => 'checkbox',
      'caption' => __('Compress Opening Hours', 'oh-opening-hours')
    ));

    $this->addField('short', array(
      'type' => 'checkbox',
      'caption' => __('Use short day captions', 'oh-opening-hours')
    ));

    $this->addField('include_io', array(
      'type' => 'checkbox',
      'caption' => __('Include Irregular Openings', 'oh-opening-hours')
    ));

    $this->addField('include_holidays', array(
      'type' => 'checkbox',
      'caption' => __('Include Holidays', 'oh-opening-hours')
    ));

    $this->addField('template', array(
      'type' => 'select',
      'caption' => __('Template', 'oh-opening-hours'),
      'options' => array(
        'table' => __('Table', 'oh-opening-hours'),
        'list' => __('List', 'oh-opening-hours')
      )
    ));

    // Extended Fields
    $this->addField('caption_closed', array(
      'type' => 'text',
      'caption' => __('Closed Caption', 'oh-opening-hours'),
      'extended' => true,
      'default_placeholder' => true
    ));

    $this->addField('highlighted_period_class', array(
      'type' => 'text',
      'caption' => __('Highlighted Period class', 'oh-opening-hours'),
      'extended' => true,
      'default_placeholder' => true
    ));

    $this->addField('highlighted_day_class', array(
      'type' => 'text',
      'caption' => __('Highlighted Day class', 'oh-opening-hours'),
      'extended' => true,
      'default_placeholder' => true
    ));

    $this->addField('time_format', array(
      'type' => 'text',
      'caption' => __('PHP Time Format', 'oh-opening-hours'),
      'extended' => true,
      'description' => self::getPhpDateFormatInfo(),
      'default_placeholder' => true
    ));

    $this->addField('hide_io_date', array(
      'type' => 'checkbox',
      'caption' => __('Hide date of Irregular Openings', 'oh-opening-hours'),
      'extended' => true
    ));

    $this->addField('week_offset', array(
      'type' => 'number',
      'caption' => __('Week offset', 'oh-opening-hours'),
      'description' => __(
        'Number of weeks the overview contents shall be offset. Might be a positive or negative integer.',
        'oh-opening-hours'
      ),
      'default_placeholder' => true,
      'extended' => true,
      'attributes' => array(
        'step' => 1,
        'min' => -52,
        'max' => 52
      )
    ));
  }
}
