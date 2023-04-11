<?php
use OH_Opening_Hours\Entity\Period;
use OH_Opening_Hours\Util\Dates;

/** @var Period $period */
$period = $this->data['period'];
?>

<div class="row flex-direction-horizontal period">
	<div class="col col-time-start">
		<input
			name="opening-hours[<?php echo esc_attr($period->getWeekday()); ?>][start][]"
			type="text"
			class="input-timepicker input-time-start"
			value="<?php echo esc_attr($period->getTimeStart()->format( Dates::STD_TIME_FORMAT )); ?>"/>
	</div>

	<div class="col col-time-end">
		<input
			name="opening-hours[<?php echo esc_attr($period->getWeekday()); ?>][end][]"
			type="text"
			class="input-timepicker input-time-end"
			value="<?php echo esc_attr($period->getTimeEnd()->format( Dates::STD_TIME_FORMAT )); ?>"/>
	</div>

	<div class="col col-delete-period">
		<a class="components-button is-destructive delete-period has-icon red">
			<i class="dashicons dashicons-no-alt"></i>
		</a>
	</div>
</div>