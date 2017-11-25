<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace tests\models;

use felicity\datamodel\ModelCollection;
use felicity\datamodel\services\datahandlers\CollectionHandler;
use PHPUnit\Framework\TestCase;
use tests\classes\DataHandlerTestModel;

/**
 * Class CollectionPropertyTest
 */
class CollectionPropertyTest extends TestCase
{
    /**
     * Runs the test
     */
    public function testModel()
    {
        $model = new DataHandlerTestModel();

        $model->unsetHandlers($model->getDefinedProperties());

        $model->setHandler('testCollection', [
            'class' => CollectionHandler::class,
        ]);

        $model->set('testCollection', 'asdf');

        self::assertNull($model->testCollection);

        $model->set('testCollection', new ModelCollection());

        self::assertInstanceOf(ModelCollection::class, $model->testCollection);

        $model->set('testCollection', new DataHandlerTestModel());

        self::assertNull($model->testCollection);
    }
}
