<?php

use OH_Opening_Hours\Entity\Holiday;
use OH_Opening_Hours\Entity\Set;
use OH_Opening_Hours\Util\Dates;

extract( $this->data['attributes'] );

/**
 * variables defined by extract
 *
 * @var         $before_widget      string w/ HTML markup before Widget
 * @var         $after_widget       string w/ HTML markup after Widget
 * @var         $before_title       string w/ HTML markup before title
 * @var         $after_title        string w/ HTML markup after title
 *
 * @var         $set                Set object
 * @var         $holidays           ArrayObject w/ Holiday objects of set
 * @var         $highlight          bool whether highlight active Holiday or not
 * @var         $title              string w/ Widget title
 *
 * @var         $class_holiday      string w/ class for holiday row
 * @var         $class_highlighted  string w/ class for highlighted Holiday
 * @var         $date_format        string w/ PHP date format
 */

if ( !count( $holidays ) )
	return;

echo wp_kses_post($before_widget);

if ( ! empty( $title ) ) {
	echo wp_kses_post($before_title) . esc_html( $title ) . wp_kses_post($after_title);
}

?>
<section class="op-table op-table-holidays">
  <div class="row">
    <?php
    /** @var Holiday $holiday */
    foreach ($holidays as $holiday) :
    $highlighted = ($highlight && $holiday->isActive()) ? $class_highlighted : '';
    ?>
    <div class="<?php echo esc_attr( $class_holiday ); ?> <?php echo esc_html( $highlighted ); ?>">
      <div class="col col-name"><?php echo esc_html( $holiday->getName() ); ?></div>

      <?php if (Dates::compareDate($holiday->getStart(), $holiday->getEnd()) === 0) : ?>
        <div class="col col-date" colspan="2"><?php echo esc_html( Dates::format($date_format, $holiday->getStart()) ); ?></div>
      <?php else: ?>
        <div class="col col-date-start"><?php echo esc_html( Dates::format($date_format, $holiday->getStart()) ); ?></div>
        <div class="col col-date-end"><?php echo esc_html( Dates::format($date_format, $holiday->getEnd()) ); ?></div>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<?php echo wp_kses_post($after_widget); ?>