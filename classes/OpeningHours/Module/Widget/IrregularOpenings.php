<?php

namespace OpeningHours\Module\Widget;

use OpeningHours\Module\OpeningHours;
use OpeningHours\Module\Shortcode\IrregularOpenings as IrregularOpeningsShortcode;

/**
 * Widget for IrregularOpenings Shortcode
 *
 * @author      Jannik Portz
 * @package     OpeningHours\Module\Widget
 */
class IrregularOpenings extends AbstractWidget {
  public function __construct() {
    $title = __('Opening Hours: Irregular Openings', 'oh-opening-hours');
    $description = __('Lists up all Irregular Openings in the selected Set.', 'oh-opening-hours');
    parent::__construct(
      'widget_op_irregular_openings',
      $title,
      $description,
      IrregularOpeningsShortcode::getInstance()
    );
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

    $this->addField('highlight', array(
      'type' => 'checkbox',
      'caption' => __('Highlight active Irregular Opening', 'oh-opening-hours')
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
      'caption' => __('Include past irregular openings', 'oh-opening-hours')
    ));

    // Extended Fields
    $this->addField('class_highlighted', array(
      'type' => 'text',
      'caption' => __('class for highlighted Irregular Opening', 'oh-opening-hours'),
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

    $this->addField('time_format', array(
      'type' => 'text',
      'caption' => __('PHP Time Format', 'oh-opening-hours'),
      'extended' => true,
      'description' => self::getPhpDateFormatInfo(),
      'default_placeholder' => true
    ));
  }
}
