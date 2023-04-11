<?php use OH_Opening_Hours\Module\CustomPostType\MetaBox\Holidays; ?>
<div class="row flex-direction-horizontal op-holiday">
	<div class="col col-name">
		<input type="text" name="<?php echo esc_attr(Holidays::POST_KEY); ?>[name][]" class="widefat" value="<?php echo esc_attr($this->data['name']); ?>" />
	</div>
	<div class="col col-date-start">
		<input type="text" name="<?php echo esc_attr(Holidays::POST_KEY); ?>[dateStart][]" class="widefat date-start input-gray" value="<?php echo esc_attr($this->data['dateStart']); ?>" />
	</div>
	<div class="col col-date-end">
		<input type="text" name="<?php echo esc_attr(Holidays::POST_KEY); ?>[dateEnd][]" class="widefat date-end input-gray" value="<?php echo esc_attr($this->data['dateEnd']); ?>" />
	</div>
	<div class="col col-remove">
		<button class="components-button is-destructive remove-holiday has-icon"><i class="dashicons dashicons-no-alt"></i></button>
	</div>
</div>