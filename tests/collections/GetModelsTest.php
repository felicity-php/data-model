<?php

namespace tests\collections;

use ReflectionException;
use PHPUnit\Framework\TestCase;
use tests\classes\ModelBasicTestModel;
use felicity\datamodel\ModelCollection;

/**
 * Class GetModels
 */
class GetModelsTest extends TestCase
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

        $arrays = $collection->getModels();

        self::assertTrue(isset($arrays[$model1->uuid]));

        self::assertTrue(isset($arrays[$model2->uuid]));
    }
}
