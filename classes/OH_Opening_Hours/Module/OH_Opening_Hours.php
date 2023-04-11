<?php

namespace OH_Opening_Hours\Module;

use OH_Opening_Hours\Entity\PostSetProvider;
use OH_Opening_Hours\Entity\Set;
use OH_Opening_Hours\Entity\SetProvider;
use OH_Opening_Hours\Util\ArrayObject;

/**
 * OH_Opening_Hours Module
 *
 * @author      Jannik Portz
 * @package     OH_Opening_Hours\Module
 */
class OH_Opening_Hours extends AbstractModule {
  const WP_FILTER_SET_PROVIDERS = 'opoh_set_providers';

  /**
   * Collection of all loaded Sets
   * @var      ArrayObject
   */
  protected $sets;

  /**
   * Array of all available SetProviders
   * @var       SetProvider[]
   */
  protected $setProviders;

  /** Constructor */
  public function __construct() {
    $this->sets = new ArrayObject();
    $this->setProviders = array();
    $this->registerHookCallbacks();
  }

  /** Register Hook Callbacks */
  public function registerHookCallbacks() {
    add_filter('detail_fields_metabox_context', function () {
      return 'side';
    });

    add_action('init', array($this, 'registerDefaultSetProviders'));
  }

  /**
   * Registers the default SetProviders and triggers opoh_set_providers filter
   */
  public function registerDefaultSetProviders() {
    $this->addSetProvider(new PostSetProvider());
    $this->setProviders = apply_filters(self::WP_FILTER_SET_PROVIDERS, $this->setProviders);
  }

  /**
   * Appends a new SetProvider
   * @param     SetProvider   $setProvider  The SetProvider to add to the list
   */
  public function addSetProvider(SetProvider $setProvider) {
    $this->setProviders[] = $setProvider;
  }

  /**
   * Returns all registered SetProviders as array
   * @return      SetProvider[]
   */
  public function getSetProviders() {
    return $this->setProviders;
  }

  /**
   * Resets the array of SetProviders to an empty list
   */
  public function clearSetProviders() {
    $this->setProviders = array();
  }

  /**
   * Getter: Sets
   * @return    ArrayObject
   */
  public static function getSets() {
    return self::getInstance()->sets;
  }

  /**
   * Returns an associative array of available set options with:
   *  key:    scalar with set id
   *  value:  string with set name
   *
   * @return    array
   */
  public function getSetsOptions() {
    $options = array();
    foreach ($this->setProviders as $setProvider) {
      $sets = $setProvider->getAvailableSetInfo();
      foreach ($sets as $setInfo) {
        if (array_key_exists('hidden', $setInfo) && $setInfo['hidden'] == true) {
          continue;
        }

        $options[$setInfo['id']] = $setInfo['name'];
      }
    }
    return $options;
  }

  /**
   * Retrieves a Set by id from the first registered SetProvider offering a Set with the specified id
   * @param     string|int  $setId  The id of the Set to retrieve
   * @return    Set|null            The Set with the specified id or null if no set could be retrieved
   */
  public function getSet($setId) {
    if ($this->sets->offsetExists($setId)) {
      return $this->sets->offsetGet($setId);
    }

    foreach ($this->setProviders as $setProvider) {
      foreach ($setProvider->getAvailableSetInfo() as $setInfo) {
        if ($setInfo['id'] == $setId) {
          $set = $setProvider->createSet($setId);
          $this->sets->offsetSet($setId, $set);
          return $set;
        }
      }
    }

    return null;
  }
}
