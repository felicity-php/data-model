<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace tests\models;

use PHPUnit\Framework\TestCase;
use tests\classes\DataHandlerTestModel;
use felicity\datamodel\services\datahandlers\FloatHandler;

/**
 * Class FloatPropertyTest
 */
class FloatPropertyTest extends TestCase
{
    /**
     * Runs the test
     */
    public function testModel()
    {
        $model = new DataHandlerTestModel();

        $model->unsetHandlers($model->getDefinedProperties());

        $model->setHandler('testFloat', [
            'class' => FloatHandler::class,
        ]);

        self::assertNull($model->get('testFloat'));

        $model->set('testFloat', 1);
        self::assertInternalType('float', $model->testFloat);
        self::assertEquals(1, $model->testFloat);

        $model->set('testFloat', 1.2);
        self::assertInternalType('float', $model->testFloat);
        self::assertEquals(1.2, $model->testFloat);

        $model->set('testFloat', 'asdf');
        self::assertInternalType('float', $model->testFloat);
        self::assertEquals(0, $model->testFloat);

        $model->set('testFloat', null);
        self::assertNull($model->get('testFloat'));
    }
}
