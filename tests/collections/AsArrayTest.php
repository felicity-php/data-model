<?php

namespace tests\collections;

use PHPUnit\Framework\TestCase;
use tests\classes\ModelBasicTestModel;
use felicity\datamodel\ModelCollection;

/**
 * Class AsArrayTest
 */
class AsArrayTest extends TestCase
{
    /**
     * Test
     */
    public function testAsArray()
    {
        $model1 = new ModelBasicTestModel([
            'testProp1' => 'testValue1',
        ]);

        $model2 = new ModelBasicTestModel([
            'testProp1' => 'testValue2',
        ]);

        $collection = new ModelCollection([
            $model1,
            $model2
        ]);

        $asArray = $collection->asArray();

        self::assertInternalType('array', $asArray);
        self::assertCount(2, $asArray);
        self::assertInternalType('array', $asArray[$model1->uuid]);
        self::assertInternalType('array', $asArray[$model2->uuid]);
        self::assertEquals($model1->asArray(), $asArray[$model1->uuid]);
        self::assertEquals($model2->asArray(), $asArray[$model2->uuid]);
    }
}
