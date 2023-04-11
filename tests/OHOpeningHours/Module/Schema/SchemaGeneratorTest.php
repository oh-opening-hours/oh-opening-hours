<?php

namespace OH_Opening_Hours\Test\Module\Schema;

use OH_Opening_Hours\Entity\ChildSetWrapper;
use OH_Opening_Hours\Entity\Holiday;
use OH_Opening_Hours\Entity\IrregularOpening;
use OH_Opening_Hours\Entity\Period;
use OH_Opening_Hours\Entity\Set;
use OH_Opening_Hours\Module\Schema\SchemaGenerator;
use OH_Opening_Hours\Module\Schema\ValidityPeriod;
use OH_Opening_Hours\Module\Schema\ValiditySequence;
use OH_Opening_Hours\Test\OpeningHoursTestCase;
use OH_Opening_Hours\Util\Dates;

class SchemaGeneratorTest extends OH_Opening_HoursTestCase {
  /**
   * - `createSetValiditySequence` creates one `ValidityPeriod` containing the main set
   *   from `$referenceNow` through one year in future
   */
  public function testCreateSetValiditySequence_NoChildren() {
    $set = new Set(0);
    $sg = new SchemaGenerator($set);

    $result = $sg->createSetValiditySequence();

    $expected = new ValiditySequence(array(new ValidityPeriod($set, -INF, INF)));

    $this->assertEquals($expected, $result);
  }

  /**
   * - `createSetValiditySequence` creates 3 `ValidityPeriods` when there is one child
   *   in the middle of the main set
   */
  public function testCreateSetValiditySequence_OneChildMiddle() {
    $set = new Set(0);
    $childSet = new Set(1);
    $child = new ChildSetWrapper($childSet, new \DateTime('2018-04-05'), new \DateTime('2018-04-10'));
    $sg = new SchemaGenerator($set, array($child));

    $result = $sg->createSetValiditySequence();

    $expected = new ValiditySequence(array(
      new ValidityPeriod($set, -INF, new \DateTime('2018-04-04')),
      new ValidityPeriod($childSet, new \DateTime('2018-04-05'), new \DateTime('2018-04-10')),
      new ValidityPeriod($set, new \DateTime('2018-04-11'), INF)
    ));

    $this->assertEquals($expected, $result);
  }

  /**
   * - `createSetValiditySequence` prepends a child period when the child is at the beginning of the whole sequence
   */
  public function testCreateSetValiditySequence_OneChildStart() {
    $set = new Set(0);
    $childSet = new Set(1);
    $child = new ChildSetWrapper($childSet, new \DateTime('2018-04-01'), new \DateTime('2018-04-10'));
    $sg = new SchemaGenerator($set, array($child));

    $result = $sg->createSetValiditySequence();

    $expected = new ValiditySequence(array(
      new ValidityPeriod($set, -INF, new \DateTime('2018-03-31')),
      new ValidityPeriod($childSet, new \DateTime('2018-04-01'), new \DateTime('2018-04-10')),
      new ValidityPeriod($set, new \DateTime('2018-04-11'), INF)
    ));

    $this->assertEquals($expected, $result);
  }

  /**
   * - `createSetValiditySequence` appends a child period when the child is at the end of the whole sequence
   */
  public function testCreateSetValiditySequence_OneChildEnd() {
    $set = new Set(0);
    $childSet = new Set(1);
    $child = new ChildSetWrapper($childSet, new \DateTime('2018-04-30'), new \DateTime('2019-03-31'));
    $sg = new SchemaGenerator($set, array($child));

    $result = $sg->createSetValiditySequence();

    $expected = new ValiditySequence(array(
      new ValidityPeriod($set, -INF, new \DateTime('2018-04-29')),
      new ValidityPeriod($childSet, new \DateTime('2018-04-30'), new \DateTime('2019-03-31')),
      new ValidityPeriod($set, new \DateTime('2019-04-01'), INF)
    ));

    $this->assertEquals($expected, $result);
  }

  /**
   * - `createSetValiditySequence` creates only one period when the child has exactly the same date range as the parent
   */
  public function testCreateSetValiditySequence_OneChildWholePeriod() {
    $set = new Set(0);
    $childSet = new Set(1);
    $child = new ChildSetWrapper($childSet, new \DateTime('2018-04-01'), new \DateTime('2019-03-31'));
    $sg = new SchemaGenerator($set, array($child));

    $result = $sg->createSetValiditySequence();

    $expected = new ValiditySequence(array(
      new ValidityPeriod($set, -INF, new \DateTime('2018-03-31')),
      new ValidityPeriod($childSet, new \DateTime('2018-04-01'), new \DateTime('2019-03-31')),
      new ValidityPeriod($set, new \DateTime('2019-04-01'), INF)
    ));

    $this->assertEquals($expected, $result);
  }

  /**
   * - `createSetValiditySequence` adds a gap period when the gap between two child periods is at least one day long
   */
  public function testCreateSetValiditySequence_TwoChildrenWithGap() {
    $set = new Set(0);
    $childSet1 = new Set(1);
    $child1 = new ChildSetWrapper($childSet1, new \DateTime('2018-04-05'), new \DateTime('2018-04-10'));
    $childSet2 = new Set(2);
    $child2 = new ChildSetWrapper($childSet2, new \DateTime('2018-04-12'), new \DateTime('2018-04-14'));
    $sg = new SchemaGenerator($set, array($child2, $child1));

    $result = $sg->createSetValiditySequence();

    $expected = new ValiditySequence(array(
      new ValidityPeriod($set, -INF, new \DateTime('2018-04-04')),
      new ValidityPeriod($childSet1, new \DateTime('2018-04-05'), new \DateTime('2018-04-10')),
      new ValidityPeriod($set, new \DateTime('2018-04-11'), new \DateTime('2018-04-11')),
      new ValidityPeriod($childSet2, new \DateTime('2018-04-12'), new \DateTime('2018-04-14')),
      new ValidityPeriod($set, new \DateTime('2018-04-15'), INF)
    ));

    $this->assertEquals($expected, $result);
  }

  /**
   * - `createSetValiditySequence` does not add gap periods when there is no gap between the child periods
   */
  public function testCreateSetValiditySequence_TwoChildrenWithoutGap() {
    $set = new Set(0);
    $childSet1 = new Set(1);
    $child1 = new ChildSetWrapper($childSet1, new \DateTime('2018-04-05'), new \DateTime('2018-04-11'));
    $childSet2 = new Set(2);
    $child2 = new ChildSetWrapper($childSet2, new \DateTime('2018-04-12'), new \DateTime('2018-04-14'));
    $sg = new SchemaGenerator($set, array($child2, $child1));

    $result = $sg->createSetValiditySequence();

    $expected = new ValiditySequence(array(
      new ValidityPeriod($set, -INF, new \DateTime('2018-04-04')),
      new ValidityPeriod($childSet1, new \DateTime('2018-04-05'), new \DateTime('2018-04-11')),
      new ValidityPeriod($childSet2, new \DateTime('2018-04-12'), new \DateTime('2018-04-14')),
      new ValidityPeriod($set, new \DateTime('2018-04-15'), INF)
    ));

    $this->assertEquals($expected, $result);
  }

  /**
   * - `createSetValiditySequence` overwrites child periods that come from a child at the beginning of the children array
   */
  public function testCreateSetValiditySequence_TwoChildrenOverlapping() {
    $set = new Set(0);
    $childSet1 = new Set(1);
    $child1 = new ChildSetWrapper($childSet1, new \DateTime('2018-04-05'), new \DateTime('2018-04-13'));
    $childSet2 = new Set(2);
    $child2 = new ChildSetWrapper($childSet2, new \DateTime('2018-04-12'), new \DateTime('2018-04-14'));
    $sg = new SchemaGenerator($set, array($child2, $child1));

    $result = $sg->createSetValiditySequence();

    $expected = new ValiditySequence(array(
      new ValidityPeriod($set, -INF, new \DateTime('2018-04-04')),
      new ValidityPeriod($childSet1, new \DateTime('2018-04-05'), new \DateTime('2018-04-13')),
      new ValidityPeriod($childSet2, new \DateTime('2018-04-14'), new \DateTime('2018-04-14')),
      new ValidityPeriod($set, new \DateTime('2018-04-15'), INF)
    ));

    $this->assertEquals($expected, $result);
  }

  /**
   * - `createSetValiditySequence` lets the child set's start date go through the parent start date
   *   if no start date has been explicitly set
   */
  public function testCreateSetValiditySequence_OneChildWithoutDateStart() {
    $set = new Set(0);
    $childSet = new Set(1);
    $child = new ChildSetWrapper($childSet, -INF, new \DateTime('2018-04-13'));
    $sg = new SchemaGenerator($set, array($child));

    $result = $sg->createSetValiditySequence();

    $expected = new ValiditySequence(array(
      new ValidityPeriod($childSet, -INF, new \DateTime('2018-04-13')),
      new ValidityPeriod($set, new \DateTime('2018-04-14'), INF)
    ));

    $this->assertEquals($expected, $result);
  }

  /**
   * - `createSetValiditySequence` lets the child set's end date go through the parent end date
   *   if no end date has been explicitly set
   */
  public function testCreateSetValiditySequence_OneChildWithoutDateEnd() {
    $set = new Set(0);
    $childSet = new Set(1);
    $child = new ChildSetWrapper($childSet, new \DateTime('2018-04-13'), INF);
    $sg = new SchemaGenerator($set, array($child));

    $result = $sg->createSetValiditySequence();

    $expected = new ValiditySequence(array(
      new ValidityPeriod($set, -INF, new \DateTime('2018-04-12')),
      new ValidityPeriod($childSet, new \DateTime('2018-04-13'), INF)
    ));

    $this->assertEquals($expected, $result);
  }

  /**
   * - `createSetValiditySequence` lets the child set's start and end date go through the parent start and end date
   *   if neither start nor end date have been explicitly set
   */
  public function testCreateSetValiditySequence_OneChildWithoutAnyDate() {
    $set = new Set(0);
    $childSet = new Set(1);
    $child = new ChildSetWrapper($childSet, -INF, INF);
    $sg = new SchemaGenerator($set, array($child));

    $result = $sg->createSetValiditySequence();

    $expected = new ValiditySequence(array(new ValidityPeriod($childSet, -INF, INF)));

    $this->assertEquals($expected, $result);
  }

  public function test_createSpecItemsFromValidityPeriod_Infinite() {
    $set = new Set(0);
    $set->getPeriods()->append(new Period(0, '12:00', '13:00'));
    $set->getPeriods()->append(new Period(6, '13:00', '14:00'));
    $sg = new SchemaGenerator($set);
    $vp = new ValidityPeriod($set, -INF, INF);

    $expected = array(
      array(
        '@type' => 'OpeningHoursSpecification',
        'opens' => '12:00',
        'closes' => '13:00',
        'dayOfWeek' => 'http://schema.org/Sunday'
      ),
      array(
        '@type' => 'OpeningHoursSpecification',
        'opens' => '13:00',
        'closes' => '14:00',
        'dayOfWeek' => 'http://schema.org/Saturday'
      )
    );

    $result = $sg->createSpecItemsFromValidityPeriod($vp);

    $this->assertEquals($expected, $result);
  }

  public function test_createSpecItemsFromValidityPeriod_StartInfinite() {
    $set = new Set(0);
    $set->getPeriods()->append(new Period(0, '12:00', '13:00'));
    $set->getPeriods()->append(new Period(6, '13:00', '14:00'));
    $sg = new SchemaGenerator($set);
    $vp = new ValidityPeriod($set, -INF, new \DateTime('2018-09-24'));

    $expected = array(
      array(
        '@type' => 'OpeningHoursSpecification',
        'opens' => '12:00',
        'closes' => '13:00',
        'dayOfWeek' => 'http://schema.org/Sunday',
        'validThrough' => '2018-09-24'
      ),
      array(
        '@type' => 'OpeningHoursSpecification',
        'opens' => '13:00',
        'closes' => '14:00',
        'dayOfWeek' => 'http://schema.org/Saturday',
        'validThrough' => '2018-09-24'
      )
    );

    $result = $sg->createSpecItemsFromValidityPeriod($vp);

    $this->assertEquals($expected, $result);
  }

  public function test_createSpecItemsFromValidityPeriod_EndInfinite() {
    $set = new Set(0);
    $set->getPeriods()->append(new Period(0, '12:00', '13:00'));
    $set->getPeriods()->append(new Period(6, '13:00', '14:00'));
    $sg = new SchemaGenerator($set);
    $vp = new ValidityPeriod($set, new \DateTime('2018-09-24'), INF);

    $expected = array(
      array(
        '@type' => 'OpeningHoursSpecification',
        'opens' => '12:00',
        'closes' => '13:00',
        'dayOfWeek' => 'http://schema.org/Sunday',
        'validFrom' => '2018-09-24'
      ),
      array(
        '@type' => 'OpeningHoursSpecification',
        'opens' => '13:00',
        'closes' => '14:00',
        'dayOfWeek' => 'http://schema.org/Saturday',
        'validFrom' => '2018-09-24'
      )
    );

    $result = $sg->createSpecItemsFromValidityPeriod($vp);

    $this->assertEquals($expected, $result);
  }

  public function test_createSpecItemsFromValidityPeriod_Finite() {
    $set = new Set(0);
    $set->getPeriods()->append(new Period(0, '12:00', '13:00'));
    $set->getPeriods()->append(new Period(6, '13:00', '14:00'));
    $sg = new SchemaGenerator($set);
    $vp = new ValidityPeriod($set, new \DateTime('2018-09-24'), new \DateTime('2018-09-25'));

    $expected = array(
      array(
        '@type' => 'OpeningHoursSpecification',
        'opens' => '12:00',
        'closes' => '13:00',
        'dayOfWeek' => 'http://schema.org/Sunday',
        'validFrom' => '2018-09-24',
        'validThrough' => '2018-09-25'
      ),
      array(
        '@type' => 'OpeningHoursSpecification',
        'opens' => '13:00',
        'closes' => '14:00',
        'dayOfWeek' => 'http://schema.org/Saturday',
        'validFrom' => '2018-09-24',
        'validThrough' => '2018-09-25'
      )
    );

    $result = $sg->createSpecItemsFromValidityPeriod($vp);

    $this->assertEquals($expected, $result);
  }

  public function test_createOpeningHoursSpecDefinition() {
    $set = new Set(0);
    $set->getPeriods()->append(new Period(0, '12:00', '13:00'));
    $set->getPeriods()->append(new Period(6, '13:00', '14:00'));
    $child = new Set(1);
    $child->getPeriods()->append(new Period(1, '15:00', '16:00'));
    $child->getPeriods()->append(new Period(5, '17:00', '18:00'));

    $sg = new SchemaGenerator($set, array($child));
    $vs = new ValiditySequence(array(
      new ValidityPeriod($set, -INF, new \DateTime('2018-09-24')),
      new ValidityPeriod($child, new \DateTime('2018-09-25'), INF)
    ));

    $expected = array(
      array(
        '@type' => 'OpeningHoursSpecification',
        'opens' => '12:00',
        'closes' => '13:00',
        'dayOfWeek' => 'http://schema.org/Sunday',
        'validThrough' => '2018-09-24'
      ),
      array(
        '@type' => 'OpeningHoursSpecification',
        'opens' => '13:00',
        'closes' => '14:00',
        'dayOfWeek' => 'http://schema.org/Saturday',
        'validThrough' => '2018-09-24'
      ),
      array(
        '@type' => 'OpeningHoursSpecification',
        'opens' => '15:00',
        'closes' => '16:00',
        'dayOfWeek' => 'http://schema.org/Monday',
        'validFrom' => '2018-09-25'
      ),
      array(
        '@type' => 'OpeningHoursSpecification',
        'opens' => '17:00',
        'closes' => '18:00',
        'dayOfWeek' => 'http://schema.org/Friday',
        'validFrom' => '2018-09-25'
      )
    );

    $result = $sg->createOpeningHoursSpecDefinition($vs);
    $this->assertEquals($expected, $result);
  }

  public function test_createHolidaysOpeningHoursSpecification() {
    $set = new Set(0);
    $set->getHolidays()->append(new Holiday('Holiday 1', new \DateTime('2018-09-24'), new \DateTime('2018-09-25')));
    $set->getHolidays()->append(new Holiday('Holiday 2', new \DateTime('2018-09-26'), new \DateTime('2018-09-27')));
    $set->getHolidays()->append(new Holiday('Holiday 3', new \DateTime('2019-09-26'), new \DateTime('2019-09-27')));
    Dates::setNow(new \DateTime('2018-09-26'));
    $sg = new SchemaGenerator($set, array());

    $expected = array(
      array(
        '@type' => 'OpeningHoursSpecification',
        'name' => 'Holiday 2',
        'validFrom' => '2018-09-26',
        'validThrough' => '2018-09-27'
      ),
      array(
        '@type' => 'OpeningHoursSpecification',
        'name' => 'Holiday 3',
        'validFrom' => '2019-09-26',
        'validThrough' => '2019-09-27'
      )
    );

    $result = $sg->createHolidaysOpeningHoursSpecification();
    $this->assertEquals($expected, $result);
  }

  public function test_createIrregularOpeningHoursSpecification() {
    $set = new Set(0);
    $set->getIrregularOpenings()->append(new IrregularOpening('IO 1', '2018-09-25', '13:00', '14:00'));
    $set->getIrregularOpenings()->append(new IrregularOpening('IO 2', '2018-09-26', '15:00', '16:00'));
    $set->getIrregularOpenings()->append(new IrregularOpening('IO 3', '2019-09-26', '15:00', '16:00'));
    Dates::setNow(new \DateTime('2018-09-26'));
    $sg = new SchemaGenerator($set, array());

    $expected = array(
      array(
        '@type' => 'OpeningHoursSpecification',
        'name' => 'IO 2',
        'opens' => '15:00',
        'closes' => '16:00',
        'validFrom' => '2018-09-26',
        'validThrough' => '2018-09-26'
      ),
      array(
        '@type' => 'OpeningHoursSpecification',
        'name' => 'IO 3',
        'opens' => '15:00',
        'closes' => '16:00',
        'validFrom' => '2019-09-26',
        'validThrough' => '2019-09-26'
      )
    );

    $result = $sg->createIrregularOpeningHoursSpecification();
    $this->assertEquals($expected, $result);
  }
}
