<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace tests\models;

use PHPUnit\Framework\TestCase;
use tests\classes\DataHandlerTestModel;
use felicity\datamodel\services\datahandlers\EmailArrayHandler;

/**
 * Class EmailArrayPropertyTest
 */
class EmailArrayPropertyTest extends TestCase
{
    /**
     * Runs the test
     */
    public function testModel()
    {
        $model = new DataHandlerTestModel();

        $model->unsetHandlers($model->getDefinedProperties());

        $model->setHandler('testEmailArray', [
            'class' => EmailArrayHandler::class,
        ]);

        self::assertNull($model->get('testEmailArray'));
        $model->set('testEmailArray', 'asdf');
        self::assertNull($model->get('testEmailArray'));
        $model->set('testEmailArray', 'test|test@gmail.com');
        self::assertCount(1, $model->testEmailArray);
    }
}
