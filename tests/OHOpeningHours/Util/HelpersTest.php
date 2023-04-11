<?php

namespace OH_Opening_Hours\Test\Util;

use OH_Opening_Hours\Test\OpeningHoursTestCase;
use OH_Opening_Hours\Util\Helpers;

class HelpersTest extends OH_Opening_HoursTestCase {
  public function testUnsetEmptyValues() {
    $expected = array(
      'foo' => 'bar',
      'bar' => 'baz',
      'baz' => 'foo'
    );

    $data = array(
      'cat' => '',
      'foo' => 'bar',
      'dog' => '',
      'bar' => 'baz',
      'donkey' => '',
      'baz' => 'foo'
    );

    $this->assertEquals($expected, Helpers::unsetEmptyValues($data));
  }
}
