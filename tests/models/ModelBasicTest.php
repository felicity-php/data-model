<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace tests\models;

use PHPUnit\Framework\TestCase;
use tests\classes\ModelBasicTestModel;

/**
 * Class ModelBasicTest
 */
class ModelBasicTest extends TestCase
{
    /**
     * Tests config setting and getting
     */
    public function testModel()
    {
        $testModel = new ModelBasicTestModel([
            'testProp1' => 'thingy',
            'erroneousProp' => 'stuff',
        ]);

        $testModel->testProp2 = 'prop2';

        $testModel->setProperty('testProp3', 'prop3');

        self::assertNull($testModel->getProperty('erroneousProp'));

        self::assertFalse(isset($testModel->erroneousProp));

        self::assertFalse($testModel->hasProperty('erroneousProp'));

        self::assertEquals('thingy', $testModel->testProp1);

        self::assertEquals('prop2', $testModel->getProperty('testProp2'));

        self::assertEquals('prop3', $testModel->testProp3);

        self::assertEquals(
            [
                'testProp1' => 'thingy',
                'testProp2' => 'prop2',
                'testProp3' => 'prop3',
                'uuid' => $testModel->uuid,
            ],
            $testModel->asArray()
        );

        self::assertEquals(
            [
                'testProp1' => 'thingy',
                'testProp2' => 'prop2',
                'testProp3' => 'prop3',
            ],
            $testModel->asArray(true)
        );
    }
}
