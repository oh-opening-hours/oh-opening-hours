<?php
/**
 * Opening Hours: View: Meta Box: IrregularOpenings
 */

use OH_Opening_Hours\Module\CustomPostType\MetaBox\IrregularOpenings as MetaBox;
use OH_Opening_Hours\Util\ViewRenderer;

/** @var \OH_Opening_Hours\Entity\IrregularOpening[] $irregular_openings */
$irregular_openings = $this->data['irregular_openings'];
?>

<div id="op-irregular-openings-wrap">

	<?php MetaBox::getInstance()->nonceField(); ?>

	<section class="op-irregular-openings" id="op-io-table">
		<header>
		<div class="col">
			<?php esc_html_e( 'Name', 'oh-opening-hours' ); ?>
		</div>

		<div class="col">
			<?php esc_html_e( 'Date', 'oh-opening-hours' ); ?>
		</div>

		<div class="col">
			<?php esc_html_e( 'Time Start', 'oh-opening-hours' ); ?>
		</div>

		<div class="col">
			<?php esc_html_e( 'Time End', 'oh-opening-hours' ); ?>
		</div>
		<div class="col-remove"></div>
		</header>

		<div class="row-wrap row flex-direction-vertical">
		<?php
		foreach ($irregular_openings as $io) {
			$view = new ViewRenderer(opoh_view_dir_path(MetaBox::TEMPLATE_PATH_SINGLE), array(
				'io' => $io
			));
			$view->render();
		}
		?>
		</div>
	</section>

	<button class="button button-primary button-add add-io">
		<?php esc_html_e( 'Add New Irregular Opening', 'oh-opening-hours' ); ?>
	</button>

</div>