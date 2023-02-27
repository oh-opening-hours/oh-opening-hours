<?php

use OpeningHours\Entity\IrregularOpening;
use OpeningHours\Entity\Set;
use OpeningHours\Util\Dates;

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

echo $before_widget;

if ( ! empty( $title ) ) {
	echo $before_title . esc_html( $title ) . $after_title;
}
?>

<table class="op-table-irregular-openings op-table op-irregular-openings">
  <tbody>
  <?php
  /** @var IrregularOpening $io */
  foreach ($irregular_openings as $io) :
    $highlighted = ($highlight && $io->isInEffect()) ? $class_highlighted : '';
  ?>
    <tr class="op-irregular-opening <?php echo esc_attr($highlighted); ?>">
      <td class="col-name"><?php echo esc_html( $io->getName() ); ?></td>
      <td class="col-date"><?php echo esc_html( Dates::format($date_format, $io->getDate()) ); ?></td>
      <td class="col-time"><?php echo esc_html( $io->getFormattedTimeRange($time_format) ); ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php echo $after_widget; ?>