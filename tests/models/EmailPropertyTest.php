<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace tests\models;

use PHPUnit\Framework\TestCase;
use tests\classes\DataHandlerTestModel;
use felicity\datamodel\services\datahandlers\EmailHandler;

/**
 * Class EmailPropertyTest
 */
class EmailPropertyTest extends TestCase
{
    /**
     * Runs the test
     */
    public function testModel()
    {
        $model = new DataHandlerTestModel();

        $model->unsetHandlers($model->getDefinedProperties());

        $model->setHandler('testEmail', [
            'class' => EmailHandler::class,
        ]);

        self::assertNull($model->get('testEmail'));
        $model->set('testEmail', 'asdf');
        self::assertNull($model->testEmail);

        $model->set('testEmail', 'asdf@asdf');
        self::assertNull($model->testEmail);

        $model->set('testEmail', 'asdf@asdf.com');
        self::assertEquals('asdf@asdf.com', $model->testEmail);
    }
}
