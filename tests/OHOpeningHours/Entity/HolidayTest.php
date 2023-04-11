<?php

namespace OH_Opening_Hours\Test\Entity;

use DateTime;
use OH_Opening_Hours\Entity\Holiday;
use OH_Opening_Hours\Test\OpeningHoursTestCase;
use OH_Opening_Hours\Util\Dates;

class HolidayTest extends OH_Opening_HoursTestCase {
  protected static $testConfig = array(
    'name' => 'Test Holiday',
    'dateStart' => '2016-01-07',
    'dateEnd' => '2016-01-23'
  );

  protected function setUp(): void {
    parent::setUp();
  }

  public function testIsActive() {
    $before = new DateTime('2016-01-06');
    $first = new DateTime('2016-01-07');
    $mid = new DateTime('2016-01-15');
    $last = new DateTime('2016-01-23');
    $after = new DateTime('2016-01-24');

    $holiday = new Holiday('Test Holiday', new DateTime('2016-01-07'), new DateTime('2016-01-23'));
    $this->assertFalse($holiday->isActive($before));
    $this->assertTrue($holiday->isActive($first));
    $this->assertTrue($holiday->isActive($mid));
    $this->assertTrue($holiday->isActive($last));
    $this->assertFalse($holiday->isActive($after));
  }

  public function testSortStrategy() {
    $h3 = new Holiday('Test3', new DateTime('2016-03-02'), new DateTime('2016-03-02'));
    $h1 = new Holiday('Test1', new DateTime('2016-01-02'), new DateTime('2016-01-02'));
    $h2 = new Holiday('Test2', new DateTime('2016-02-02'), new DateTime('2016-02-02'));
    $h4 = new Holiday('Test4', new DateTime('2016-03-02'), new DateTime('2016-04-02'));

    $holidays = array($h3, $h1, $h2);
    usort($holidays, array(get_class($h1), 'sortStrategy'));
    $this->assertEquals($h1, $holidays[0]);
    $this->assertEquals($h2, $holidays[1]);
    $this->assertEquals($h3, $holidays[2]);
    $this->assertEquals(0, Holiday::sortStrategy($h3, $h4));
  }

  public function testCreateDummyPeriod() {
    $holiday = Holiday::createDummyPeriod();
    $now = new DateTime('now');
    $format = 'Y-m-d';

    $this->assertEquals('', $holiday->getName());
    $this->assertEquals($now->format($format), $holiday->getStart()->format($format));
    $this->assertEquals($now->format($format), $holiday->getEnd()->format($format));
    $this->assertTrue($holiday->isDummy());
  }

  public function testDateSetters() {
    $holiday = new Holiday('Test Holiday', new DateTime('2016-01-02'), new DateTime('2016-01-03'));

    $this->assertEquals(new DateTime('2016-01-02 00:00:00'), $holiday->getStart());
    $this->assertEquals(new DateTime('2016-01-03 23:59:59', Dates::getTimezone()), $holiday->getEnd());
  }

  public function testIsPast() {
    $holiday = new Holiday('Test Holiday', new DateTime('2017-04-28'), new DateTime('2017-04-29'));

    $this->assertFalse($holiday->isPast(new DateTime('2017-04-27 23:59:59')));
    $this->assertFalse($holiday->isPast(new DateTime('2017-04-28 00:00:00')));
    $this->assertFalse($holiday->isPast(new DateTime('2017-04-29 23:59:59')));
    $this->assertTrue($holiday->isPast(new DateTime('2017-04-30 00:00:00')));
    $this->assertTrue($holiday->isPast(new DateTime('2017-05-01 00:00:00')));
  }

  public function testHappensOnDate() {
    $holiday = new Holiday('Test Holiday', new DateTime('2017-04-27'), new DateTime('2017-04-29'));

    $this->assertFalse($holiday->happensOnDate(new DateTime('2017-04-26')));
    $this->assertTrue($holiday->happensOnDate(new DateTime('2017-04-27 00:00:00')));
    $this->assertTrue($holiday->happensOnDate(new DateTime('2017-04-27')));
    $this->assertTrue($holiday->happensOnDate(new DateTime('2017-04-28')));
    $this->assertTrue($holiday->happensOnDate(new DateTime('2017-04-29')));
    $this->assertTrue($holiday->happensOnDate(new DateTime('2017-04-29 23:59:59')));
    $this->assertFalse($holiday->happensOnDate(new DateTime('2017-04-30')));
  }

  public function testGetFormattedDateRange() {
    $start = new DateTime('2017-05-01');
    $end = new DateTime('2017-05-02');
    $holiday = new Holiday('Holiday', $start, $end);
    $expected = '2017-05-01;2017-05-02';

    \WP_Mock::wpFunction('date_i18n', array(
      'times' => 1,
      'args' => array(Dates::STD_DATE_FORMAT, (int) $start->format('U')),
      'return' => '2017-05-01'
    ));

    \WP_Mock::wpFunction('date_i18n', array(
      'times' => 1,
      'args' => array(Dates::STD_DATE_FORMAT, (int) $end->format('U')),
      'return' => '2017-05-02'
    ));

    $result = $holiday->getFormattedDateRange(Dates::STD_DATE_FORMAT, '%s;%s');
    $this->assertEquals($expected, $result);
  }

  public function testGetFormattedDateRangeSingleDate() {
    $start = new DateTime('2017-05-01');
    $holiday = new Holiday('Holiday', $start, $start);
    $expected = '2017-05-01';

    \WP_Mock::wpFunction('date_i18n', array(
      'times' => 1,
      'args' => array(Dates::STD_DATE_FORMAT, (int) $start->format('U')),
      'return' => '2017-05-01'
    ));

    $result = $holiday->getFormattedDateRange(Dates::STD_DATE_FORMAT, '%s;%s');
    $this->assertEquals($expected, $result);
  }
}
