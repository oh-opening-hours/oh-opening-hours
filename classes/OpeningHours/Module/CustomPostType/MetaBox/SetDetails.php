<?php

namespace OpeningHours\Module\CustomPostType\MetaBox;

use OpeningHours\Fields\MetaBoxFieldRenderer;
use OpeningHours\Util\MetaBoxPersistence;
use WP_Post;

/**
 * Meta Box for setting up set details
 *
 * @author      Jannik Portz
 * @package     OpeningHours\Module\CustomPostType\MetaBox
 */
class SetDetails extends AbstractMetaBox {
  const FILTER_ALIAS_PRESETS = 'op_set_alias_presets';
  const SHORTCODE_BUILDER_FORMAT = 'https://oh-opening-hours.github.io/oh-shortcode-builder#%s';

  /**
   * Array of field configuration arrays
   * @var       array[]
   */
  protected $fields;

  /**
   * The MetaBoxPersistence for the detail meta box
   * @var       MetaBoxPersistence
   */
  protected $persistence;

  /**
   * The FieldRenderer used to render the meta box fields
   * @var       MetaBoxFieldRenderer
   */
  protected $fieldRenderer;

  public function __construct() {
    parent::__construct(
      'op_meta_box_set_details',
      __('Set Details', 'oh-opening-hours'),
      self::CONTEXT_SIDE,
      self::PRIORITY_HIGH
    );
    $this->fieldRenderer = new MetaBoxFieldRenderer($this->id);
    $this->persistence = new MetaBoxPersistence($this->id);

    $filterAliasPrefix = self::FILTER_ALIAS_PRESETS;

    $this->fields = array(
      array(
        'type' => 'textarea',
        'name' => 'description',
        'caption' => __('Description', 'oh-opening-hours'),
      ),
      array(
        'type' => 'text',
        'name' => 'dateStart',
        'caption' => __('Date Start', 'oh-opening-hours'),
        'show_when' => 'child',
        'attributes' => array(
          'class' => 'op-criteria-date-start op-date-input'
        )
      ),
      array(
        'type' => 'text',
        'name' => 'dateEnd',
        'caption' => __('Date End', 'oh-opening-hours'),
        'show_when' => 'child',
        'attributes' => array(
          'class' => 'op-criteria-date-end op-date-input'
        )
      ),
      array(
        'type' => 'select',
        'name' => 'weekScheme',
        'caption' => __('Week Scheme', 'oh-opening-hours'),
        'options' => array(
          'all' => __('Every week', 'oh-opening-hours'),
          'even' => __('Even weeks only', 'oh-opening-hours'),
          'odd' => __('Odd weeks only', 'oh-opening-hours')
        ),
        'show_when' => 'child'
      ),
      array(
        'type' => 'text',
        'name' => 'alias',
        'caption' => __('Set Alias', 'oh-opening-hours'),
        'description' => __('Use an alias instead of the Set ID in shortcodes', 'oh-opening-hours'),
        'datalist' => function () use ($filterAliasPrefix) {
          return (array) apply_filters($filterAliasPrefix, array());
        },
        'show_when' => 'parent'
      ),
      array(
        'type' => 'heading',
        'name' => 'childSetNotice',
        'heading' => __('Add a Child-Set', 'oh-opening-hours'),
        'description' => __(
          'You may add a child set that overwrites the parent Opening Hours in a specific time range. Choose a parent set under "Attributes".',
          'oh-opening-hours'
        ),
        'show_when' => 'parent'
      )
    );
  }

  /**
   * Creates the URL including the sets option containing only the current set for the Shortcode Builder
   *
   * @param     WP_Post     $post     The post whose set to include in the sets
   * @return    string                The URL for the Shortcode Builder
   */
  private function createShortcodeBuilderUrl(WP_Post $post) {
    $sets = array();
    $sets[$post->ID] = $post->post_title;
    $shortcodeGeneratorHash = base64_encode(
      json_encode(array(
        'sets' => $sets
      ))
    );

    return sprintf(self::SHORTCODE_BUILDER_FORMAT, $shortcodeGeneratorHash);
  }

  /** @inheritdoc */
  public function renderMetaBox(WP_Post $post) {
    $this->nonceField();
    $builderUrl = $this->createShortcodeBuilderUrl($post);

    echo '<p>';
    echo '<h3>' . __('Set Id', 'oh-opening-hours') . ': <code>' . $post->ID . '</code></h3>';
    // prettier-ignore
    echo '<a class="op-generate-sc-link" data-shortcode-builder-url="' . $builderUrl . '" href="' . $builderUrl . '" target="_blank">' . __('Create a Shortcode', 'oh-opening-hours') . '</a>';
    echo '</h3>';

    $type = $post->post_parent == 0 ? 'parent' : 'child';

    foreach ($this->fields as $field) {
      if (array_key_exists('show_when', $field) && $field['show_when'] != $type) {
        continue;
      }

      $value = $this->persistence->getValue($field['name'], $post->ID);
      echo $this->fieldRenderer->getFieldMarkup($field, $value);
    }
  }

  /** @inheritdoc */
  protected function saveData($post_id, WP_Post $post, $update) {
    if (!array_key_exists($this->id, $_POST)) {
      return;
    }

    $data = isset($_POST[$this->id]) ? $_POST[$this->id]: '' ;
    foreach ($this->fields as $field) {
      $value = array_key_exists($field['name'], $data) ? $data[$field['name']] : null;
      $this->persistence->putValue($field['name'], $value, $post_id);
    }
  }

  /**
   * Returns the persistence manager for the meta box
   * @return    MetaBoxPersistence
   */
  public function getPersistence() {
    return $this->persistence;
  }
}
