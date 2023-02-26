<?php

namespace OpeningHours\Module\Shortcode;

use OpeningHours\Entity\Holiday;
use OpeningHours\Entity\IrregularOpening;
use OpeningHours\Entity\Period;
use OpeningHours\Entity\Set;
use OpeningHours\Module\OpeningHours;
use OpeningHours\Util\Dates;
use OpeningHours\Util\Weekdays;

/**
 * Shortcode implementation for a list or regular Opening Periods
 *
 * @author      Jannik Portz
 * @package     OpeningHours\Module\Shortcode
 */
class Overview extends AbstractShortcode {
  const FILTER_OVERVIEW_MODEL = 'op_overview_model';

  /** @inheritdoc */
  protected function init() {
    $this->setShortcodeTag('op-overview');

    $this->defaultAttributes = array(
      'before_title' => '<h3 class="op-overview-title">',
      'after_title' => '</h3>',
      'before_widget' => '<div class="op-overview-shortcode">',
      'after_widget' => '</div>',
      'set_id' => 0,
      'title' => null,
      'show_closed_days' => false,
      'show_description' => false,
      'highlight' => 'nothing',
      'compress' => false,
      'short' => false,
      'include_io' => false,
      'include_holidays' => false,
      'caption_closed' => __('Closed', 'oh-opening-hours'),
      'highlighted_period_class' => 'highlighted',
      'highlighted_day_class' => 'highlighted',
      'time_format' => Dates::getTimeFormat(),
      'hide_io_date' => false,
      'template' => 'table',
      'week_offset' => 0
    );

    $this->validAttributeValues = array(
      'highlight' => array('nothing', 'period', 'day'),
      'show_closed_days' => array(false, true),
      'show_description' => array(false, true),
      'include_io' => array(false, true),
      'include_holidays' => array(false, true),
      'hide_io_date' => array(false, true),
      'template' => array('table', 'list')
    );
  }

  /** @inheritdoc */
  public function shortcode(array $attributes) {
    if (!isset($attributes['set_id'])) {
      trigger_error("Set id not properly set in Opening Hours Overview shortcode");
      return;
    }

    $templateMap = array(
      'table' => 'shortcode/overview.php',
      'list' => 'shortcode/overview-list.php'
    );

    $setId = $attributes['set_id'];
    $set = OpeningHours::getInstance()->getSet($setId);

    if (!$set instanceof Set) {
      return;
    }

    $attributes['set'] = $set;

    $model = apply_filters(self::FILTER_OVERVIEW_MODEL, null, $set, $attributes);

    if (!$model instanceof OverviewModel) {
      $now = clone Dates::getNow();

      if (is_numeric($attributes['week_offset']) && $attributes['week_offset'] != 0) {
        $weekOffset = (int) $attributes['week_offset'];
        $interval = new \DateInterval(sprintf('P%dW', (int) abs($attributes['week_offset'])));

        if ($weekOffset > 0) {
          $now->add($interval);
        } else {
          $now->sub($interval);
        }
      }

      $model = new OverviewModel($set->getPeriods()->getArrayCopy(), $now);

      if ($attributes['include_holidays']) {
        $model->mergeHolidays($set->getHolidays()->getArrayCopy());
      }

      if ($attributes['include_io']) {
        $model->mergeIrregularOpenings($set->getIrregularOpenings()->getArrayCopy());
      }
    }

    $data = $attributes['compress'] ? $model->getCompressedData() : $model->getData();

    $days = array();
    foreach ($data as $row) {
      if (!$attributes['show_closed_days'] && is_array($row['items']) && count($row['items']) < 1) {
        continue;
      }

      $dayData = array(
        'highlightedDayClass' =>
          $attributes['highlight'] === 'day' && Weekdays::containsToday($row['days'])
            ? $attributes['highlighted_day_class']
            : '',
        'dayCaption' => Weekdays::getDaysCaption($row['days'], $attributes['short'])
      );

      if ($row['items'] instanceof IrregularOpening) {
        $dayData['periodsMarkup'] = self::renderIrregularOpening($row['items'], $attributes);
      } elseif ($row['items'] instanceof Holiday) {
        $dayData['periodsMarkup'] = self::renderHoliday($row['items']);
      } elseif (count($row['items']) > 0) {
        $markup = '';
        /** @var Period $period */
        foreach ($row['items'] as $period) {
          ($highlightedPeriod = $attributes['highlight'] == 'period') and
            ($period->isOpenOnAny($row['days'], $set) ? $attributes['highlighted_period_class'] : '');
          $markup .= sprintf(
            '<span class="op-period-time %s">%s</span>',
            esc_attr($highlightedPeriod),
            $period->getFormattedTimeRange($attributes['time_format'])
          );
        }
        $dayData['periodsMarkup'] = $markup;
      } else {
        $dayData['periodsMarkup'] = '<span class="op-closed">' . esc_html($attributes['caption_closed']) . '</span>';
      }

      $days[] = $dayData;
    }

    $attributes['days'] = $days;

    echo $this->renderShortcodeTemplate($attributes, $templateMap[$attributes['template']]);
  }

  /**
   * Renders an Irregular Opening Item for Overview table
   *
   * @param     IrregularOpening $io         The Irregular Opening to show
   * @param     array            $attributes The shortcode attributes
   * @return    string                       The markup for the Irregular Opening
   */
  public static function renderIrregularOpening(IrregularOpening $io, array $attributes) {
    $name = $io->getName();
    $date = Dates::format(Dates::getDateFormat(), $io->getStart());
    $markup = '';

    $heading = $attributes['hide_io_date'] ? $name : sprintf('%s (%s)', $name, $date);

    $now = Dates::getNow();
    $highlighted =
      $attributes['highlight'] == 'period' && $io->getStart() <= $now && $now <= $io->getEnd()
        ? $attributes['highlighted_period_class']
        : null;

    $markup .= sprintf('<span class="op-period-time irregular-opening %s">%s</span>', esc_attr($highlighted), esc_html($heading));

    $time_start = $io->getStart()->format($attributes['time_format']);
    $time_end = $io->getEnd()->format($attributes['time_format']);

    $markup .= sprintf('<span class="op-period-time %s">%s – %s</span>', esc_attr($highlighted), $time_start, $time_end);
    return $markup;
  }

  /**
   * Renders a Holiday Item for Overview table
   *
   * @param     Holiday $holiday    The Holiday item to show
   * @return    string              The holiday markup
   */
  public static function renderHoliday(Holiday $holiday) {
    return '<span class="op-period-time op-closed holiday">' . esc_html($holiday->getName()) . '</span>';
  }
}
