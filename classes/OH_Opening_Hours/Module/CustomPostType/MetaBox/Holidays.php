<?php

namespace OH_Opening_Hours\Module\CustomPostType\MetaBox;

use DateTime;
use OH_Opening_Hours\Entity\Holiday;
use OH_Opening_Hours\Module\OH_Opening_Hours as OH_Opening_HoursModule;
use OH_Opening_Hours\Util\Dates;
use OH_Opening_Hours\Util\Persistence;
use OH_Opening_Hours\Util\ViewRenderer;
use WP_Post;

/**
 * Meta Box implementation for Holidays meta box
 *
 * @author      Jannik Portz
 * @package     OH_Opening_Hours\Module\CustomPostType\MetaBox
 */
class Holidays extends AbstractMetaBox {
  const TEMPLATE_PATH = 'meta-box/holidays.php';
  const TEMPLATE_PATH_SINGLE = 'ajax/op-set-holiday.php';

  const POST_KEY = 'opening-hours-holidays';

  public function __construct() {
    parent::__construct(
      'opoh_meta_box_holidays',
      __('Holidays', 'oh-opening-hours'),
      self::CONTEXT_ADVANCED,
      self::PRIORITY_HIGH
    );
  }

  /** @inheritdoc */
  public function registerMetaBox() {
    if (!$this->currentSetIsParent()) {
      return;
    }

    parent::registerMetaBox();
  }

  /** @inheritdoc */
  public function renderMetaBox(WP_Post $post) {
    $set = $this->getSet($post->ID);

    if (count($set->getHolidays()) < 1) {
      $set->getHolidays()->append(Holiday::createDummyPeriod());
    }

    $variables = array(
      'holidays' => $set->getHolidays()
    );

    $vr = new ViewRenderer(opoh_view_dir_path(self::TEMPLATE_PATH), $variables);
    $vr->render();
  }

  /**
   * Renders a single holiday row
   *
   * @param     Holiday $holiday The Holiday to render
   */
  public function renderSingleHoliday(Holiday $holiday) {
    $data = array(
      'name' => $holiday->getName(),
      'dateStart' => $holiday->isDummy() ? '' : $holiday->getStart()->format(Dates::STD_DATE_FORMAT),
      'dateEnd' => $holiday->isDummy() ? '' : $holiday->getEnd()->format(Dates::STD_DATE_FORMAT)
    );

    $vr = new ViewRenderer(opoh_view_dir_path(self::TEMPLATE_PATH_SINGLE), $data);
    $vr->render();
  }

  /** @inheritdoc */
  protected function saveData($post_id, WP_Post $post, $update) {
    $holidays =
      array_key_exists(self::POST_KEY, $_POST) && is_array($postData = $_POST[self::POST_KEY])
        ? $this->getHolidaysFromPostData($postData)
        : array();

    $persistence = new Persistence($post);
    $persistence->saveHolidays($holidays);
  }

  /**
   * Converts the post data to a Holiday array
   *
   * @param     array $data The POST data from the edit screen
   *
   * @return    Holiday[]           The Holiday array
   */
  public function getHolidaysFromPostData(array $data) {
    $holidays = array();
    for ($i = 0; $i < count($data['name']); $i++) {
      if (!empty($data['name'][$i]) && (empty($data['dateStart'][$i]) || empty($data['dateEnd'][$i]))) {
        continue;
      }

      try {
        $holiday = new Holiday(
          $data['name'][$i],
          new DateTime($data['dateStart'][$i]),
          new DateTime($data['dateEnd'][$i])
        );
        $holidays[] = $holiday;
      } catch (\InvalidArgumentException $e) {
        // ignore item
      }
    }
    return $holidays;
  }
}
