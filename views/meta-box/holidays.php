<?php
use OpeningHours\Module\CustomPostType\MetaBox\Holidays;

$holidays = Holidays::getInstance();
?>

<div id="op-holidays-wrap">
	<?php Holidays::getInstance()->nonceField(); ?>
	<table class="op-holidays" id="op-holidays-table">
		<thead>
		<th>
			<?php esc_html_e( 'Name', 'oh-opening-hours' ); ?>
		</th>

		<th>
			<?php esc_html_e( 'Date Start', 'oh-opening-hours' ); ?>
		</th>

		<th>
			<?php esc_html_e( 'Date End', 'oh-opening-hours' ); ?>
		</th>
		</thead>

		<tbody>
		<?php foreach ( $this->data['holidays'] as $holiday ) $holidays->renderSingleHoliday( $holiday ); ?>
		</tbody>
	</table>

	<button class="button button-primary button-add add-holiday">
		<?php esc_html_e( 'Add New Holiday', 'oh-opening-hours' ); ?>
	</button>
</div>