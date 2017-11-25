<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace tests\models;

use PHPUnit\Framework\TestCase;
use tests\classes\DataHandlerTestModel;
use felicity\datamodel\services\datahandlers\IntHandler;

/**
 * Class IntPropertyTest
 */
class IntPropertyTest extends TestCase
{
    /**
     * Runs the test
     */
    public function testModel()
    {
        $model = new DataHandlerTestModel();

        $model->unsetHandlers($model->getDefinedProperties());

        $model->setHandler('testInt', [
            'class' => IntHandler::class,
        ]);

        self::assertNull($model->get('testInt'));

        $model->set('testInt', 1);
        self::assertInternalType('int', $model->testInt);
        self::assertEquals(1, $model->testInt);

        $model->set('testInt', 1.2);
        self::assertInternalType('int', $model->testInt);
        self::assertEquals(1, $model->testInt);

        $model->set('testInt', 'asdf');
        self::assertInternalType('int', $model->testInt);
        self::assertEquals(0, $model->testInt);

        $model->set('testInt', null);
        self::assertNull($model->get('testInt'));
    }
}
