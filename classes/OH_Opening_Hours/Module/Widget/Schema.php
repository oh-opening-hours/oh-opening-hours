<?php

namespace OH_Opening_Hours\Module\Widget;

use OH_Opening_Hours\Module\OH_Opening_Hours;
use OH_Opening_Hours\Module\Shortcode\Schema as SchemaShortcode;

/**
 * Widget for Schema.org Shortcode
 *
 * @author      Jannik Portz
 * @package     OH_Opening_Hours\Module\Widget
 */
class Schema extends AbstractWidget {
  public function __construct() {
    $title = __('Opening Hours: Schema.org', 'oh-opening-hours');
    $description = __(
      'Inserts script-Tag containing schema.org specifications for a Set in JSON-LD format.',
      'oh-opening-hours'
    );
    parent::__construct('widget_opoh_schema', $title, $description, SchemaShortcode::getInstance());
  }

  /** @inheritdoc */
  protected function registerFields() {
    // Standard Fields
    $this->addField('set_id', array(
      'type' => 'select',
      'caption' => __('Set', 'oh-opening-hours'),
      'options_callback' => array(OH_Opening_Hours::getInstance(), 'getSetsOptions')
    ));

    $this->addField('exclude_holidays', array(
      'type' => 'checkbox',
      'caption' => __('Exclude Holidays', 'oh-opening-hours')
    ));

    $this->addField('exclude_irregular_openings', array(
      'type' => 'checkbox',
      'caption' => __('Exclude Irregular Openings', 'oh-opening-hours')
    ));

    $this->addField('schema_attr_type', array(
      'type' => 'text',
      'caption' => __('<code>@Type</code> property of the schema object', 'oh-opening-hours'),
      'extended' => true,
      'default_placeholder' => true
    ));

    $this->addField('schema_attr_name', array(
      'type' => 'text',
      'caption' => __('<code>name</code> property of the schema object', 'oh-opening-hours'),
      'extended' => true,
      'description' => 'Leave empty to use the selected Set\'s name'
    ));

    $this->addField('schema_attr_description', array(
      'type' => 'text',
      'caption' => __('<code>description</code> property of the schema object', 'oh-opening-hours'),
      'extended' => true,
      'description' => 'Leave empty to use the selected Set\'s description'
    ));
  }
}
