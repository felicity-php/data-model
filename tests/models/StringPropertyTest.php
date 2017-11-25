<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace tests\models;

use PHPUnit\Framework\TestCase;
use tests\classes\DataHandlerTestModel;
use felicity\datamodel\services\datahandlers\StringHandler;

/**
 * Class StringPropertyTest
 */
class StringPropertyTest extends TestCase
{
    /**
     * Runs the test
     */
    public function testModel()
    {
        $model = new DataHandlerTestModel();

        $model->unsetHandlers($model->getDefinedProperties());

        $model->setHandler('testString', [
            'class' => StringHandler::class,
        ]);

        self::assertNull($model->get('testString'));

        $model->set('testString', 1);
        self::assertInternalType('string', $model->testString);
        self::assertEquals('1', $model->testString);

        $model->set('testString', 1.2);
        self::assertInternalType('string', $model->testString);
        self::assertEquals('1.2', $model->testString);

        $model->set('testString', 'asdf');
        self::assertInternalType('string', $model->testString);
        self::assertEquals('asdf', $model->testString);

        $model->set('testString', null);
        self::assertNull($model->get('testString'));
    }
}
