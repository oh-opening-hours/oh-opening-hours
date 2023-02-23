<?php

namespace OpeningHours\Module\Widget;

use OpeningHours\Module\OpeningHours;
use OpeningHours\Module\Shortcode\IsOpen as IsOpenShortcode;

/**
 * Widget for IsOpen Shortcode
 *
 * @author      Jannik Portz
 * @package     OpeningHours\Module\Widget
 */
class IsOpen extends AbstractWidget {
  public function __construct() {
    $title = __('Opening Hours: Is Open Status', 'oh-opening-hours');
    $description = __(
      'Shows a box saying whether a specific set is currently open or closed based on Periods.',
      'oh-opening-hours'
    );
    parent::__construct('widget_op_is_open', $title, $description, IsOpenShortcode::getInstance());
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
      'options_callback' => array(OpeningHours::getInstance(), 'getSetsOptions')
    ));

    $this->addField('show_next', array(
      'type' => 'checkbox',
      'caption' => __('Show next open Period', 'oh-opening-hours')
    ));

    $this->addField('show_today', array(
      'type' => 'select',
      'caption' => __('Show todays opening hours', 'oh-opening-hours'),
      'options' => array(
        'never' => __('Never', 'oh-opening-hours'),
        'open' => __('When open', 'oh-opening-hours'),
        'always' => __('Always', 'oh-opening-hours')
      )
    ));

    $this->addField('show_closed_holidays', array(
      'type' => 'checkbox',
      'caption' => __('Show Holiday name(s) when closed', 'oh-opening-hours')
    ));

    // Extended Fields
    $this->addField('open_text', array(
      'type' => 'text',
      'caption' => __('Caption if open', 'oh-opening-hours'),
      'extended' => true,
      'default_placeholder' => true
    ));

    $this->addField('closed_text', array(
      'type' => 'text',
      'caption' => __('Caption if closed', 'oh-opening-hours'),
      'extended' => true,
      'default_placeholder' => true
    ));

    $this->addField('closed_holiday_text', array(
      'type' => 'text',
      'caption' => __('Caption if closed and day has holiday(s)', 'oh-opening-hours'),
      'extended' => true,
      'default_placeholder' => true,
      'description' => sprintf('%s: %s', '<code>%1$s</code>', __('Formatted Holiday Names String', 'oh-opening-hours'))
    ));

    $this->addField('open_class', array(
      'type' => 'text',
      'caption' => __('Class if open (span)', 'oh-opening-hours'),
      'extended' => true,
      'default_placeholder' => true
    ));

    $this->addField('closed_class', array(
      'type' => 'text',
      'caption' => __('Class if closed (span)', 'oh-opening-hours'),
      'extended' => true,
      'default_placeholder' => true
    ));

    $this->addField('next_format', array(
      'type' => 'text',
      'caption' => __('Next Period String Format', 'oh-opening-hours'),
      'extended' => true,
      'default_placeholder' => true,
      'description' => sprintf(
        '%s: %s<br />%s: %s<br />%s: %s<br />%s: %s',
        '<code>%1$s</code>',
        __('Formatted Date', 'oh-opening-hours'),
        '<code>%2$s</code>',
        __('Weekday', 'oh-opening-hours'),
        '<code>%3$s</code>',
        __('Formatted Start Time', 'oh-opening-hours'),
        '<code>%4$s</code>',
        __('Formatted End Time', 'oh-opening-hours')
      )
    ));

    $this->addField('today_format', array(
      'type' => 'text',
      'caption' => __('Todays opening hours format', 'oh-opening-hours'),
      'extended' => true,
      'default_placeholder' => true,
      'description' => sprintf(
        '%s: %s<br />%s: %s<br />%s: %s',
        '<code>%1$s</code>',
        __('Formatted time range of all periods', 'oh-opening-hours'),
        '<code>%2$s</code>',
        __('Formatted start time of first period on that day', 'oh-opening-hours'),
        '<code>%3$s</code>',
        __('Formatted end time of last period on that day', 'oh-opening-hours')
      )
    ));

    $this->addField('classes', array(
      'type' => 'text',
      'caption' => __('Class for span', 'oh-opening-hours'),
      'extended' => true,
      'default_placeholder' => true
    ));

    $this->addField('date_format', array(
      'type' => 'text',
      'caption' => __('PHP Date Format', 'oh-opening-hours'),
      'extended' => true,
      'default_placeholder' => true,
      'description' => self::getPhpDateFormatInfo()
    ));

    $this->addField('time_format', array(
      'type' => 'text',
      'caption' => __('PHP Time Format', 'oh-opening-hours'),
      'extended' => true,
      'default_placeholder' => true,
      'description' => self::getPhpDateFormatInfo()
    ));
  }
}
