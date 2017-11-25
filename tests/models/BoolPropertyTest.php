<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace tests\models;

use PHPUnit\Framework\TestCase;
use tests\classes\DataHandlerTestModel;

/**
 * Class ModelBasicTest
 */
class BoolPropertyTest extends TestCase
{
    /**
     * Runs the test
     */
    public function testModel()
    {
        $model = new DataHandlerTestModel();

        self::assertNull($model->testBool);

        $model->setProperty('testBool', '1');
        self::assertInternalType('boolean', $model->testBool);
        self::assertTrue($model->testBool);

        $model->setProperty('testBool', 1);
        self::assertInternalType('boolean', $model->testBool);
        self::assertTrue($model->testBool);

        $model->setProperty('testBool', 'true');
        self::assertInternalType('boolean', $model->testBool);
        self::assertTrue($model->testBool);

        $model->setProperty('testBool', true);
        self::assertInternalType('boolean', $model->testBool);
        self::assertTrue($model->testBool);

        $model->setProperty('testBool', 'y');
        self::assertInternalType('boolean', $model->testBool);
        self::assertTrue($model->testBool);

        $model->setProperty('testBool', 'yes');
        self::assertInternalType('boolean', $model->testBool);
        self::assertTrue($model->testBool);

        $model->setProperty('testBool', '0');
        self::assertInternalType('boolean', $model->testBool);
        self::assertFalse($model->testBool);

        $model->setProperty('testBool', 0);
        self::assertInternalType('boolean', $model->testBool);
        self::assertFalse($model->testBool);

        $model->setProperty('testBool', 'false');
        self::assertInternalType('boolean', $model->testBool);
        self::assertFalse($model->testBool);

        $model->setProperty('testBool', false);
        self::assertInternalType('boolean', $model->testBool);
        self::assertFalse($model->testBool);

        $model->setProperty('testBool', 'n');
        self::assertInternalType('boolean', $model->testBool);
        self::assertFalse($model->testBool);

        $model->setProperty('testBool', 'no');
        self::assertInternalType('boolean', $model->testBool);
        self::assertFalse($model->testBool);

        $model->setProperty('testBool', 'asdf');
        self::assertInternalType('boolean', $model->testBool);
        self::assertFalse($model->testBool);
    }
}
