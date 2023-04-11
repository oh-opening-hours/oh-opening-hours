<?php
use OH_Opening_Hours\Module\CustomPostType\MetaBox\Holidays;

$holidays = Holidays::getInstance();
?>

<div id="op-holidays-wrap">
	<?php Holidays::getInstance()->nonceField(); ?>
	<section class="op-holidays" id="op-holidays-table">
		<header>
		<div class="col">
			<?php esc_html_e( 'Name', 'oh-opening-hours' ); ?>
		</div>

		<div class="col">
			<?php esc_html_e( 'Date Start', 'oh-opening-hours' ); ?>
		</div>

		<div class="col">
			<?php esc_html_e( 'Date End', 'oh-opening-hours' ); ?>
		</div>
		<div class="col-remove"></div>
		</header>

		<div class="row-wrap row flex-direction-vertical">
		<?php foreach ( $this->data['holidays'] as $holiday ) $holidays->renderSingleHoliday( $holiday ); ?>
		</div>
	</section>

	<button class="button button-primary button-add add-holiday">
		<?php esc_html_e( 'Add New Holiday', 'oh-opening-hours' ); ?>
	</button>
</div>