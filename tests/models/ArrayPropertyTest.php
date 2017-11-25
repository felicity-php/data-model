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
class ArrayPropertyTest extends TestCase
{
    /**
     * Runs the test
     */
    public function testModel()
    {
        $model = new DataHandlerTestModel();

        self::assertNull($model->getProperty('testArray'));

        $model->testArray = 'test';
        $model->castValues(['asdf']);
        self::assertFalse(\is_array($model->testArray));
        $model->castValues();
        self::assertInternalType('array', $model->testArray);
        self::assertCount(1, $model->testArray);
        self::assertEquals(['test'], $model->testArray);

        $model->testArray = 'test|test2';
        $model->castValues(['testArray']);
        self::assertInternalType('array', $model->testArray);
        self::assertCount(2, $model->testArray);
        self::assertEquals(array('test', 'test2'), $model->testArray);

        $testArray = [
            'test1',
            'test2'
        ];

        $model->testArray = $testArray;
        $model->castValues();
        self::assertInternalType('array', $model->testArray);
        self::assertCount(2, $model->testArray);
        self::assertEquals($testArray, $model->testArray);
    }
}
