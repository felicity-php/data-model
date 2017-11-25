<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace tests\models\validation;

use PHPUnit\Framework\TestCase;
use tests\classes\DataHandlerTestModel;
use felicity\datamodel\services\datahandlers\ArrayHandler;

/**
 * Class ModelBasicTest
 */
class AddErrorTest extends TestCase
{
    /**
     * Runs the test
     */
    public function testModel()
    {
        $model = new DataHandlerTestModel();

        $model->unsetHandlers($model->getDefinedProperties());

        $model->setHandler('testArray', [
            'class' => ArrayHandler::class,
            'required' => true,
        ]);

        self::assertFalse($model->validate());

        self::assertTrue($model->hasErrors());

        $model->setProperty('testArray', 'testVal');

        self::assertTrue($model->validate());

        self::assertFalse($model->hasErrors());

        $model->addError('testArray', 'test message');

        self::assertTrue($model->hasErrors());

        self::assertEquals(
            [
                'testArray' => [
                    0 => 'test message',
                ],
            ],
            $model->getErrors()
        );

        $model->setProperty('testArray', null);

        self::assertFalse($model->validate());

        $model->addError('testArray', 'test message');

        self::assertEquals(
            [
                'testArray' => [
                    0 => 'This field is required',
                    1 => 'test message',
                ],
            ],
            $model->getErrors()
        );
    }
}
