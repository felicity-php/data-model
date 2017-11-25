<?php

namespace tests\models\validation;

use felicity\datamodel\services\datahandlers\BoolHandler;
use PHPUnit\Framework\TestCase;
use tests\classes\DataHandlerTestModel;

/**
 * Class ValidateBoolTest
 * @group modelTests
 */
class ValidateBoolTest extends TestCase
{
    /**
     * Test
     */
    public function test()
    {
        $model = new DataHandlerTestModel();

        $model->unsetHandlers($model->getDefinedProperties());

        $model->setHandler('testBool', [
            'class' => BoolHandler::class,
            'required' => true,
        ]);

        self::assertFalse($model->validate());
        self::assertTrue($model->hasErrors());
        self::assertInternalType('array', $model->getErrors());
        self::assertArrayHasKey('testBool', $model->getErrors());
        self::assertCount(1, $model->getErrors()['testBool']);
        self::assertEquals(
            'This field is required',
            $model->getErrors()['testBool'][0]
        );

        $model->setProperty('testBool', false);
        self::assertTrue($model->validate());
        self::assertFalse($model->hasErrors());
        self::assertInternalType('array', $model->getErrors());
        self::assertCount(0, $model->getErrors());
    }
}
