<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace tests\models;

use DateTimeZone;
use PHPUnit\Framework\TestCase;
use tests\classes\DataHandlerTestModel;
use felicity\datamodel\services\datahandlers\DateTimeZoneHandler;

/**
 * Class DateTimeZonePropertyTest
 */
class DateTimeZonePropertyTest extends TestCase
{
    /**
     * Runs the test
     */
    public function testModel()
    {
        $model = new DataHandlerTestModel();

        $model->unsetHandlers($model->getDefinedProperties());

        $model->setHandler('testDateTimeZone', [
            'class' => DateTimeZoneHandler::class,
        ]);

        $model->set('testDateTimeZone', 'asdf');

        self::assertNull($model->testDateTimeZone);

        $model->set('testDateTimeZone', new DateTimeZone('America/Chicago'));

        self::assertInstanceOf(DateTimeZone::class, $model->testDateTimeZone);

        $model->set('testCollection', 'America/New_York');

        self::assertInstanceOf(DateTimeZone::class, $model->testDateTimeZone);

        $model->set('testDateTimeZone', 'thing');

        self::assertNull($model->testDateTimeZone);
    }
}
