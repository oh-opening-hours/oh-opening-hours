<?php

namespace OH_Opening_Hours\Test\Util;

use OH_Opening_Hours\Test\OpeningHoursTestCase;
use OH_Opening_Hours\Util\ViewRenderer;

class ViewRendererTest extends OH_Opening_HoursTestCase {
  public function test_viewRenderer() {
    $data = array(
      'firstName' => 'Peter',
      'foo' => 'Cat',
      'bar' => 'Dog'
    );

    $template = __DIR__ . '/../../views/test-view.php';

    $viewRenderer = new ViewRenderer($template, $data);
    $expected = "Hello Peter,\nCat Dog.";

    $this->assertEquals($expected, $viewRenderer->getContents());
  }
}
