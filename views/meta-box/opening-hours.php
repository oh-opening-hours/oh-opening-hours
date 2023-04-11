<?php

use OH_Opening_Hours\Module\CustomPostType\MetaBox\OH_Opening_Hours as MetaBox;
use OH_Opening_Hours\Util\ViewRenderer;
use OH_Opening_Hours\Util\Weekday;

MetaBox::getInstance()->nonceField();
?>

<div class="opening-hours">
	<section class="form-table form-opening-hours">
		<div class="row-wrap row flex-direction-vertical">
		<?php foreach ( $this->data['periods'] as $day ) :
			/** @var Weekday $weekday */
			$weekday = $day['day'];
			?>
			<div class="periods-day row flex-direction-horizontal">
				<div class="col col-name" valign="top">
					<?php echo esc_html($weekday->getName()); ?>
				</div>

				<div class="col col-times" colspan="2" valign="top">
					<div class="period-container" data-day="<?php echo esc_attr($weekday->getIndex()); ?>"
						data-set="<?php echo esc_attr($this->data['set']->getId()); ?>">

						<section class="period-table">
							<div class="row-wrap row flex-direction-vertical">
							<?php foreach ( $day['periods'] as $period ) {
								$vr = new ViewRenderer(opoh_view_dir_path(MetaBox::TEMPLATE_PATH_SINGLE), array(
									'period' => $period
								) );
								wp_kses_post($vr->render());
							} ?>
							</div>
						</section>

					</div>
				</div>

				<div class="col col-options" valign="top">
					<a class="components-button add-period green has-icon">
						<i class="dashicons dashicons-plus"></i>
					</a>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
	</section>
</div>