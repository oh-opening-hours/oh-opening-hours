<?php
/**
 * Opening Hours: View: Meta Box: IrregularOpenings
 */

use OpeningHours\Module\CustomPostType\MetaBox\IrregularOpenings as MetaBox;
use OpeningHours\Util\ViewRenderer;

/** @var \OpeningHours\Entity\IrregularOpening[] $irregular_openings */
$irregular_openings = $this->data['irregular_openings'];
?>

<div id="op-irregular-openings-wrap">

	<?php MetaBox::getInstance()->nonceField(); ?>

	<table class="op-irregular-openings" id="op-io-table">
		<thead>
		<th>
			<?php esc_html_e( 'Name', 'oh-opening-hours' ); ?>
		</th>

		<th>
			<?php esc_html_e( 'Date', 'oh-opening-hours' ); ?>
		</th>

		<th>
			<?php esc_html_e( 'Time Start', 'oh-opening-hours' ); ?>
		</th>

		<th>
			<?php esc_html_e( 'Time End', 'oh-opening-hours' ); ?>
		</th>
		</thead>

		<tbody>
		<?php
		foreach ($irregular_openings as $io) {
			$view = new ViewRenderer(op_view_dir_path(MetaBox::TEMPLATE_PATH_SINGLE), array(
				'io' => $io
			));
			$view->render();
		}
		?>
		</tbody>
	</table>

	<button class="button button-primary button-add add-io">
		<?php esc_html_e( 'Add New Irregular Opening', 'oh-opening-hours' ); ?>
	</button>

</div>