<?php

namespace OH_Opening_Hours\Test\Util;

use OH_Opening_Hours\Test\OpeningHoursTestCase;
use OH_Opening_Hours\Util\MetaBoxPersistence;

class MetaBoxPersistenceTest extends OH_Opening_HoursTestCase {
  public function testGenerateMetaKey() {
    $p = new MetaBoxPersistence('my_namespace');
    $this->assertEquals('_my_namespace_my_key', $p->generateMetaKey('my_key'));
  }

  public function testGetValue() {
    $p = new MetaBoxPersistence('my_namespace');
    \WP_Mock::wpFunction('get_post_meta', array(
      'times' => 1,
      'args' => array(64, '_my_namespace_my_key', true),
      'return' => array('foo' => 'bar')
    ));
    $this->assertEquals(array('foo' => 'bar'), $p->getValue('my_key', 64));
  }

  public function testPutValue() {
    $p = new MetaBoxPersistence('my_namespace');
    \WP_Mock::wpFunction('update_post_meta', array(
      'times' => 1,
      'args' => array(64, '_my_namespace_my_key', array('foo' => 'bar'))
    ));
    $p->putValue('my_key', array('foo' => 'bar'), 64);
  }
}
