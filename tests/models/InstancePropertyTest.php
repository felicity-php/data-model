<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace tests\models;

use PHPUnit\Framework\TestCase;
use tests\classes\ModelBasicTestModel;
use tests\classes\DataHandlerTestModel;
use felicity\datamodel\services\datahandlers\InstanceHandler;

/**
 * Class InstancePropertyTest
 */
class InstancePropertyTest extends TestCase
{
    /**
     * Runs the test
     */
    public function testModel()
    {
        $model = new DataHandlerTestModel();

        $model->unsetHandlers($model->getDefinedProperties());

        $model->setHandler('testInstance', [
            'class' => InstanceHandler::class,
            'expect' => ModelBasicTestModel::class,
        ]);

        self::assertNull($model->get('testInstance'));

        $model->set('testInstance', 'asdf');
        self::assertNull($model->get('testInstance'));

        $model->set('testInstance', new ModelBasicTestModel());
        self::assertInstanceOf(ModelBasicTestModel::class, $model->testInstance);
    }
}
