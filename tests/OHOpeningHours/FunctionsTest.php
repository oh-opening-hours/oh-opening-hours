<?php

namespace OH_Opening_Hours\Test;

use OH_Opening_Hours\Entity\Holiday;
use OH_Opening_Hours\Entity\IrregularOpening;
use OH_Opening_Hours\Entity\Period;
use OH_Opening_Hours\Module\CustomPostType\Set;
use OH_Opening_Hours\Util\Dates;

class FunctionsTest extends OH_Opening_HoursTestCase {
  protected static $getPostsArgs = array(
    'post_type' => Set::CPT_SLUG,
    'numberposts' => 1,
    'post_parent' => 0,
    'orderby' => 'menu_order',
    'order' => 'ASC'
  );

  public function setUp(): void {
    parent::setUp();
    require_once __DIR__ . '/../../functions.php';
  }

  public function testIsOpenClosedNoSet() {
    \WP_Mock::wpFunction('get_posts', array(
      'times' => 4,
      'args' => array(self::$getPostsArgs),
      'return' => array()
    ));

    $this->assertFalse(is_open());
    $this->assertEquals(array(false, 'period'), is_open(true));
    $this->assertTrue(is_closed());
    $this->assertEquals(array(true, 'period'), is_closed(true));
  }

  public function testIsOpenClosed() {
    $post = $this->getMockBuilder('WP_Post')->getMock();
    $post->ID = 64;

    \WP_Mock::wpFunction('get_posts', array(
      'times' => '1+',
      'args' => array(self::$getPostsArgs),
      'return' => array($post)
    ));

    $set = $this->createSet(
      64,
      array(new Period(1, '13:00', '15:00')),
      array(new Holiday('Holiday', new \DateTime('2016-09-22'), new \DateTime('2016-09-23'))),
      array(new IrregularOpening('IO', '2016-09-24', '13:00', '15:00'))
    );

    \OpeningHours\Module\OpeningHours::getSets()->offsetSet(64, $set);

    $oldDate = Dates::getNow();
    Dates::setNow(new \DateTime('2016-09-19 12:59'));
    $this->assertFalse(is_open());
    Dates::setNow(new \DateTime('2016-09-19 13:00'));
    $this->assertTrue(is_open());
    $this->assertEquals(array(true, 'period'), is_open(true));

    Dates::setNow(new \DateTime('2016-09-21 23:59:59'));
    $this->assertFalse(is_open());
    $this->assertEquals(array(false, 'period'), is_open(true));

    Dates::setNow(new \DateTime('2016-09-22 00:00:00'));
    $this->assertFalse(is_open());
    $this->assertEquals(array(false, 'holiday'), is_open(true));

    Dates::setNow(new \DateTime('2016-09-24 12:59:00'));
    $this->assertFalse(is_open());
    Dates::setNow(new \DateTime('2016-09-24 13:00:00'));
    $this->assertTrue(is_open());
    $this->assertEquals(array(true, 'special_opening'), is_open(true));

    Dates::setNow($oldDate);
  }
}
