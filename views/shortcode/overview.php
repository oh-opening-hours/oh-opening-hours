<?php

use OH_Opening_Hours\Entity\Set;
use OH_Opening_Hours\Module\OH_Opening_Hours;

extract( $this->data['attributes'] );

/**
 * Variables defined by extraction
 *
 * @var       $before_widget      string w/ html before widget
 * @var       $after_widget       string w/ html after widget
 * @var       $before_title       string w/ html before title
 * @var       $after_title        string w/ html after title
 *
 * @var       $title              string w/ widget title
 * @var       $show_description   bool whether to show description or not
 * @var       $days               array containing per day data
 *
 * @var       $set                Set whose Opening Hours to show
 */

echo wp_kses_post($before_widget);

if ( $title ) {
	echo wp_kses_post($before_title) . esc_html( $title ) . wp_kses_post($after_title);
}

$description = $set->getDescription();
?>

<section class="op-table op-table-overview">
  <?php if ($show_description && !empty($description)) : ?>
    <div class="op-row op-row-description">
      <div class="col op-cell op-cell-description" colspan="2"><?php echo esc_html( $description ) ?></div>
    </div>
  <?php endif; ?>

  <?php foreach ($days as $dayData) : ?>
  <div class="op-row op-row-day <?php echo esc_attr( $dayData['highlightedDayClass'] ); ?>">
    <div class="op-cell op-cell-heading" scope="row"><?php echo esc_html($dayData['dayCaption']); ?></div>
    <div class="col op-cell op-cell-periods"><?php echo wp_kses_post($dayData['periodsMarkup']); ?></div>
  </div>
  <?php endforeach; ?>
</section>

<?php echo wp_kses_post($after_widget); ?>