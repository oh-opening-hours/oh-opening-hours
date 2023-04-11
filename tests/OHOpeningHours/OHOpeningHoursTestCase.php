<?php

namespace OH_Opening_Hours\Test;

use OH_Opening_Hours\Entity\Set;
use OH_Opening_Hours\Util\ArrayObject;
use WP_Mock\Functions;

abstract class OH_Opening_HoursTestCase extends \PHPUnit\Framework\TestCase {
  protected function setUp(): void  {
    parent::setUp();
    \WP_Mock::setUp();

    $defaultOptions = array(
      'date_format' => 'Y-m-d',
      'time_format' => 'H:i',
      'start_of_week' => 0
    );

    $this->applyOptionsMap($defaultOptions);

    \WP_Mock::wpPassthruFunction('__');
    \WP_Mock::wpPassthruFunction('_e');
    \WP_Mock::wpPassthruFunction('_x');
    \WP_Mock::wpPassthruFunction('_n');
    \WP_Mock::wpFunction('current_time', array(
      'times' => '0+',
      'args' => array('Y-m-d H:i:s'),
      'return' => date('Y-m-d H:i:s', time())
    ));
  }

  protected function tearDown(): void  {
    parent::tearDown();
    \WP_Mock::tearDown();
  }

  /**
   * Sets option values
   * @param     array     $map      Associative array containing key-value pairs representing an option
   */
  protected function applyOptionsMap(array $map) {
    foreach ($map as $key => $value) {
      \WP_Mock::wpFunction('get_option', array(
        'times' => '0+',
        'args' => array($key),
        'return' => $value
      ));

      \WP_Mock::wpFunction('get_option', array(
        'times' => '0+',
        'args' => array($key, Functions::type('string')),
        'return' => $value
      ));
    }

    \WP_Mock::wpFunction('get_option', array(
      'times' => '0+',
      'args' => array('start_of_week', Functions::type('int'))
    ));
  }

  protected function createSet(
    $id,
    array $periods = array(),
    array $holidays = array(),
    array $irregularOpenings = array()
  ) {
    $set = new Set($id);
    $set->setPeriods(ArrayObject::createFromArray($periods));
    $set->setHolidays(ArrayObject::createFromArray($holidays));
    $set->setIrregularOpenings(ArrayObject::createFromArray($irregularOpenings));
    return $set;
  }
}
