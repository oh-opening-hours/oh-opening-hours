<?php

namespace OH_Opening_Hours\Module\Shortcode;

use OH_Opening_Hours\Util\DateTimeRange;
use OH_Opening_Hours\Entity\Set;
use OH_Opening_Hours\Module\OH_Opening_Hours;
use OH_Opening_Hours\Util\Dates;

/**
 * Shortcode implementation for a list of Irregular Openings
 *
 * @author      Jannik Portz
 * @package     OH_Opening_Hours\Module\Shortcode
 */
class IrregularOpenings extends AbstractShortcode {
  /** @inheritdoc */
  protected function init() {
    $this->setShortcodeTag('op-irregular-openings');

    $this->defaultAttributes = array(
      'title' => null,
      'set_id' => null,
      'highlight' => false,
      'before_widget' => '<div class="op-irregular-openings-shortcode">',
      'after_widget' => '</div>',
      'before_title' => '<h3 class="op-irregular-openings-title">',
      'after_title' => '</h3>',
      'class_highlighted' => 'highlighted',
      'date_format' => Dates::getDateFormat(),
      'time_format' => Dates::getTimeFormat(),
      'template' => 'table',
      'include_past' => false
    );

    $this->validAttributeValues = array(
      'highlight' => array(false, true),
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
      'table' => 'shortcode/irregular-openings.php',
      'list' => 'shortcode/irregular-openings-list.php'
    );

    $ios = $set->getIrregularOpenings()->getArrayCopy();
    $ios = DateTimeRange::sortObjects($ios, !$attributes['include_past']);

    $attributes['set'] = $set;
    $attributes['irregular_openings'] = $ios;

    echo $this->renderShortcodeTemplate($attributes, $templateMap[$attributes['template']]);
  }
}
