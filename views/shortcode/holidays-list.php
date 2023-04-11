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
<dl class="op-list op-list-holidays">
    <?php
    /** @var Holiday $holiday */
    foreach ($holidays as $holiday) :
    $highlighted = ($highlight && $holiday->isActive()) ? $class_highlighted : '';
    ?>
    <dt class="<?php echo esc_attr( $highlighted ); ?>"><?php echo esc_html( $holiday->getName() ); ?></dt>
    <dd class="<?php echo esc_attr( $highlighted ); ?>"><?php echo esc_html( $holiday->getFormattedDateRange($date_format) ); ?></dd>
    <?php endforeach; ?>
</dl>

<?php echo wp_kses_post($after_widget); ?>