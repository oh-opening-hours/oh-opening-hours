<?php

use OH_Opening_Hours\Entity\IrregularOpening;
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
 * @var         $irregular_openings ArrayObject w/ IrregularOpening objects of set
 * @var         $highlight          bool whether highlight active Holiday or not
 * @var         $title              string w/ Widget title
 *
 * @var         $class_highlighted  string w/ class for highlighted IrregularOpening
 * @var         $date_format        string w/ PHP date format
 * @var         $time_format        string w/ PHP time format
 */

if ( !count( $irregular_openings ) )
	return;

echo wp_kses_post($before_widget);

if ( ! empty( $title ) ) {
	echo wp_kses_post($before_title) . esc_html( $title ) . wp_kses_post($after_title);
}
?>

<section class="op-table-irregular-openings op-table op-irregular-openings">
  <div class="row">
  <?php
  /** @var IrregularOpening $io */
  foreach ($irregular_openings as $io) :
    $highlighted = ($highlight && $io->isInEffect()) ? $class_highlighted : '';
  ?>
    <div class="op-irregular-opening <?php echo esc_attr($highlighted); ?>">
      <div class="col col-name"><?php echo esc_html( $io->getName() ); ?></div>
      <div class="col col-date"><?php echo esc_html( Dates::format($date_format, $io->getDate()) ); ?></div>
      <div class="col col-time"><?php echo esc_html( $io->getFormattedTimeRange($time_format) ); ?></div>
    </div>
  <?php endforeach; ?>
  </div>
</section>

<?php echo wp_kses_post($after_widget); ?>