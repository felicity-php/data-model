<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace tests\models;

use DateTime;
use PHPUnit\Framework\TestCase;
use tests\classes\DataHandlerTestModel;
use felicity\datamodel\services\datahandlers\DateTimeHandler;

/**
 * Class DateTimePropertyTest
 */
class DateTimePropertyTest extends TestCase
{
    /**
     * Runs the test
     */
    public function testModel()
    {
        $model = new DataHandlerTestModel();

        $model->unsetHandlers($model->getDefinedProperties());

        $model->setHandler('testDateTime', [
            'class' => DateTimeHandler::class,
        ]);

        self::assertNull($model->get('testDateTime'));
        $model->set('testDateTime', 'asdf');
        self::assertNull($model->testDateTime);

        $model->set('testDateTime', new DateTime());
        self::assertInstanceOf(DateTime::class, $model->testDateTime);

        $model->set('testDateTime', 1501998027);
        self::assertInstanceOf(DateTime::class, $model->testDateTime);

        $model->set('testDateTime', '1501998027');
        self::assertInstanceOf(DateTime::class, $model->testDateTime);

        $model->set('testDateTime', '');
        self::assertEquals(time(), $model->testDateTime->getTimestamp());

        $yesterday = new \DateTime('yesterday');
        $model->set('testDateTime', 'yesterday');
        self::assertEquals(
            $yesterday->getTimestamp(),
            $model->testDateTime->getTimestamp()
        );

        $test = new \DateTime('2017-06-20 16:06:02');
        $model->set('testDateTime', '2017-06-20 16:06:02');
        self::assertEquals(
            $test->getTimestamp(),
            $model->testDateTime->getTimestamp()
        );

        $test = new \DateTime('2010-01-01 00:00:00');
        $model->set('testDateTime', $test);
        self::assertEquals(
            $test->getTimestamp(),
            $model->testDateTime->getTimestamp()
        );
    }
}
