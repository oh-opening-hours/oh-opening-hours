<?php

namespace OH_Opening_Hours\Test\Util;

use DateTime;
use DateTimeZone;
use OH_Opening_Hours\Test\OpeningHoursTestCase;
use OH_Opening_Hours\Util\Dates;

class DatesTest extends OH_Opening_HoursTestCase {
  public function testIsValidTime() {
    $this->assertTrue(Dates::isValidTime('01:30'));
    $this->assertFalse(Dates::isValidTime('01:348'));
  }

  public function testMergeDateIntoTime() {
    $date = new DateTime();
    $date->setDate(2016, 1, 2);
    $time = new DateTime();
    $time->setDate(2014, 3, 1);

    $time = Dates::mergeDateIntoTime($date, $time);
    $format = 'Y-m-d';
    $this->assertEquals($date->format($format), $time->format($format));
  }

  public function testApplyTimezone() {
    $date = new DateTime('now', new DateTimeZone('America/Anchorage'));
    Dates::applyTimeZone($date);
    $this->assertEquals(Dates::getTimezone(), $date->getTimezone());
  }

  public function testApplyWeekContext() {
    $now = new DateTime('2016-01-13'); // Wed
    $date = new DateTime('2016-03-12');

    $this->assertEquals(new DateTime('2016-01-18'), Dates::applyWeekContext(clone $date, 1, $now));
    $this->assertEquals(new DateTime('2016-01-19'), Dates::applyWeekContext(clone $date, 2, $now));
    $this->assertEquals(new DateTime('2016-01-13'), Dates::applyWeekContext(clone $date, 3, $now));
    $this->assertEquals(new DateTime('2016-01-14'), Dates::applyWeekContext(clone $date, 4, $now));
    $this->assertEquals(new DateTime('2016-01-15'), Dates::applyWeekContext(clone $date, 5, $now));
    $this->assertEquals(new DateTime('2016-01-16'), Dates::applyWeekContext(clone $date, 6, $now));
    $this->assertEquals(new DateTime('2016-01-17'), Dates::applyWeekContext(clone $date, 0, $now));
  }

  public function testCompareDateTime() {
    $this->assertEquals(0, Dates::compareDateTime(new DateTime('2018-05-18'), new DateTime('2018-05-18')));
    $this->assertEquals(
      -1,
      Dates::compareDateTime(new DateTime('2018-05-18 00:00:00'), new DateTime('2018-05-18 00:00:01'))
    );
    $this->assertEquals(
      1,
      Dates::compareDateTime(new DateTime('2018-05-18 00:00:01'), new DateTime('2018-05-18 00:00:00'))
    );

    $this->assertEquals(0, Dates::compareDateTime(INF, INF));
    $this->assertEquals(0, Dates::compareDateTime(-INF, -INF));
    $this->assertEquals(INF, Dates::compareDateTime(INF, -INF));
    $this->assertEquals(-INF, Dates::compareDateTime(-INF, INF));

    $this->assertEquals(-INF, Dates::compareDateTime(new DateTime('now'), INF));
    $this->assertEquals(INF, Dates::compareDateTime(new DateTime('now'), -INF));
    $this->assertEquals(INF, Dates::compareDateTime(INF, new DateTime('now')));
    $this->assertEquals(-INF, Dates::compareDateTime(-INF, new DateTime('now')));
  }

  public function testGetFloatRepresentation() {
    $date = new DateTime('now');
    $this->assertEquals((float) $date->getTimestamp(), Dates::getFloatFrom($date));
    $this->assertEquals(-INF, Dates::getFloatFrom(-INF));
    $this->assertEquals(INF, Dates::getFloatFrom(INF));
    $this->assertEquals(INF, Dates::getFloatFrom(INF));
    $this->assertEquals(0, Dates::getFloatFrom('2018-05-18'));
  }

  public function testMin() {
    $this->assertEquals(-INF, Dates::min(-INF, -INF));
    $this->assertEquals(INF, Dates::min(INF, INF));
    $this->assertEquals(-INF, Dates::min(-INF, INF));
    $this->assertEquals(-INF, Dates::min(INF, -INF));
    $this->assertEquals(-INF, Dates::min(new DateTime('2018-06-01'), -INF));
    $this->assertEquals(new DateTime('2018-06-01'), Dates::min(new DateTime('2018-06-01'), INF));
    $this->assertEquals(new DateTime('2018-06-01'), Dates::min(new DateTime('2018-06-01'), new DateTime('2018-06-02')));
    $this->assertEquals(new DateTime('2018-06-01'), Dates::min(new DateTime('2018-06-02'), new DateTime('2018-06-01')));
  }

  public function testMax() {
    $this->assertEquals(-INF, Dates::max(-INF, -INF));
    $this->assertEquals(INF, Dates::max(INF, INF));
    $this->assertEquals(INF, Dates::max(-INF, INF));
    $this->assertEquals(INF, Dates::max(INF, -INF));
    $this->assertEquals(new DateTime('2018-06-01'), Dates::max(new DateTime('2018-06-01'), -INF));
    $this->assertEquals(INF, Dates::max(new DateTime('2018-06-01'), INF));
    $this->assertEquals(new DateTime('2018-06-02'), Dates::max(new DateTime('2018-06-01'), new DateTime('2018-06-02')));
    $this->assertEquals(new DateTime('2018-06-02'), Dates::max(new DateTime('2018-06-02'), new DateTime('2018-06-01')));
  }

  public function testCompareTime() {
    $d1 = new DateTime('2016-02-03 12:30');
    $d2 = new DateTime('2016-12-23 01:45');

    $this->assertEquals(-1, Dates::compareTime($d2, $d1));
    $this->assertEquals(0, Dates::compareTime($d1, $d1));
    $this->assertEquals(1, Dates::compareTime($d1, $d2));
  }

  public function testCompareDate() {
    $d1 = new DateTime('2016-02-03 12:30');
    $d2 = new DateTime('2016-04-02 11:30');
    $d3 = new DateTime('2016-02-03 13:30');

    $this->assertEquals(-1, Dates::compareDate($d1, $d2));
    $this->assertEquals(0, Dates::compareDate($d1, $d3));
    $this->assertEquals(1, Dates::compareDate($d2, $d1));
  }
}
