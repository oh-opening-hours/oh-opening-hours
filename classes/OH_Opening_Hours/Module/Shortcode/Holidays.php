<?php

namespace OH_Opening_Hours\Module\Shortcode;

use OH_Opening_Hours\Entity\Set;
use OH_Opening_Hours\Module\OH_Opening_Hours;
use OH_Opening_Hours\Util\Dates;
use OH_Opening_Hours\Util\DateTimeRange;

/**
 * Shortcode implementation for a list of Holidays
 *
 * @author      Jannik Portz
 * @package     OH_Opening_Hours\Module\Shortcode
 */
class Holidays extends AbstractShortcode {
  /** @inheritdoc */
  protected function init() {
    $this->setShortcodeTag('op-holidays');

    $this->defaultAttributes = array(
      'title' => null,
      'set_id' => null,
      'highlight' => false,
      'before_widget' => '<div class="op-holidays-shortcode">',
      'after_widget' => '</div>',
      'before_title' => '<h3 class="op-holidays-title">',
      'after_title' => '</h3>',
      'class_holiday' => 'op-holiday',
      'class_highlighted' => 'highlighted',
      'date_format' => Dates::getDateFormat(),
      'template' => 'table',
      'include_past' => false
    );

    $this->validAttributeValues = array(
      'template' => array('table', 'list'),
      'include_past' => array(false, true)
    );
  }

  /** @inheritdoc */
  public function shortcode(array $attributes) {
    $setId = $attributes['set_id'];

    $set = OH_Opening_Hours::getInstance()->getSet($setId);

    if (!$set instanceof Set) {
      return;
    }

    $templateMap = array(
      'table' => 'shortcode/holidays.php',
      'list' => 'shortcode/holidays-list.php'
    );

    $holidays = $set->getHolidays()->getArrayCopy();
    $holidays = DateTimeRange::sortObjects($holidays, !$attributes['include_past']);

    $attributes['set'] = $set;
    $attributes['holidays'] = $holidays;
    echo $this->renderShortcodeTemplate(($attributes), $templateMap[$attributes['template']]);
  }
}
