<?php

use OH_Opening_Hours\Module\CustomPostType\MetaBox\IrregularOpenings as MetaBox;
use OH_Opening_Hours\Util\Dates;

/** @var \OH_Opening_Hours\Entity\IrregularOpening $io */
$io = $this->data['io'];

/** @var \OH_Opening_Hours\Entity\IrregularOpening $io */
$name = $io->getName();
$date = ( $io->isDummy() ) ? null : $io->getDate()->format( Dates::STD_DATE_FORMAT );
$timeStart = ( $io->isDummy() ) ? null : $io->getStart()->format( Dates::STD_TIME_FORMAT );
$timeEnd = ( $io->isDummy() ) ? null : $io->getEnd()->format( Dates::STD_TIME_FORMAT );
?>

<div class="row flex-direction-horizontal op-irregular-opening">
  <div class="col col-name">
    <input type="text" class="widefat name" name="<?php echo esc_attr(MetaBox::POST_KEY); ?>[name][]" value="<?php echo esc_attr($name); ?>" >
  </div>

  <div class="col col-date">
    <input type="text" class="widefat date input-gray" name="<?php echo esc_attr(MetaBox::POST_KEY); ?>[date][]" value="<?php echo esc_attr($date); ?>">
  </div>

  <div class="col col-time-start">
    <input type="text" class="widefat time-start input-timepicker input-gray" name="<?php echo esc_attr(MetaBox::POST_KEY); ?>[timeStart][]" value="<?php echo esc_attr($timeStart); ?>">
  </div>

  <div class="col col-time-end">
    <input type="text" class="widefat time-end input-timepicker input-gray" name="<?php echo esc_attr(MetaBox::POST_KEY); ?>[timeEnd][]" value="<?php echo esc_attr($timeEnd); ?>">
  </div>

  <div class="col col-remove">
    <button class="components-button is-destructive remove-io has-icon"><i class="dashicons dashicons-no-alt"></i></button>
  </div>
</div>