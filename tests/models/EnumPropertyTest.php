<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace tests\models;

use felicity\datamodel\services\datahandlers\EnumHandler;
use PHPUnit\Framework\TestCase;
use tests\classes\DataHandlerTestModel;

/**
 * Class EnumPropertyTest
 */
class EnumPropertyTest extends TestCase
{
    /**
     * Runs the test
     */
    public function testModel()
    {
        $model = new DataHandlerTestModel();

        $model->unsetHandlers($model->getDefinedProperties());

        $model->setHandler('testEnum', [
            'class' => EnumHandler::class,
            'expect' => [
                123,
                'someVal',
            ],
        ]);

        self::assertNull($model->get('testEnum'));
        $model->set('testEnum', 'asdf');
        self::assertNull($model->testEnum);

        $model->set('testEnum', 'someVal');
        self::assertEquals('someVal', $model->testEnum);

        $model->set('testEnum', 123);
        self::assertEquals(123, $model->testEnum);
    }
}
