<?php

namespace tests\collections;

use PHPUnit\Framework\TestCase;
use tests\classes\ModelBasicTestModel;
use felicity\datamodel\ModelCollection;

/**
 * Class RemoveModelTest
 */
class RemoveModelTest extends TestCase
{
    /**
     * Test removeModel
     */
    public function testRemoveModel()
    {
        $model1 = new ModelBasicTestModel();
        $model2 = new ModelBasicTestModel();
        $model3 = new ModelBasicTestModel();
        $model4 = new ModelBasicTestModel();

        $collection = new ModelCollection([$model1, $model2, $model3, $model4]);

        self::assertCount(4, $collection);
        $uuids = $collection->pluck('uuid');
        self::assertTrue(in_array($model1->uuid, $uuids));
        self::assertTrue(in_array($model2->uuid, $uuids));
        self::assertTrue(in_array($model3->uuid, $uuids));
        self::assertTrue(in_array($model4->uuid, $uuids));

        $collection->removeModel($model1);
        $uuids = $collection->pluck('uuid');
        self::assertCount(3, $collection);
        self::assertFalse(in_array($model1->uuid, $uuids));
        self::assertTrue(in_array($model2->uuid, $uuids));
        self::assertTrue(in_array($model3->uuid, $uuids));
        self::assertTrue(in_array($model4->uuid, $uuids));

        $collection->addModel($model1);
        self::assertCount(4, $collection);
        $collection->removeModel($model2->uuid);
        $uuids = $collection->pluck('uuid');
        self::assertCount(3, $collection);
        self::assertTrue(in_array($model1->uuid, $uuids));
        self::assertFalse(in_array($model2->uuid, $uuids));
        self::assertTrue(in_array($model3->uuid, $uuids));
        self::assertTrue(in_array($model4->uuid, $uuids));

        $collection->removeModel(2);
        self::assertCount(2, $collection);
        $uuids = $collection->pluck('uuid');
        self::assertTrue(in_array($model1->uuid, $uuids));
        self::assertFalse(in_array($model2->uuid, $uuids));
        self::assertFalse(in_array($model3->uuid, $uuids));
        self::assertTrue(in_array($model4->uuid, $uuids));

        $collection->emptyCollection();
        self::assertCount(0, $collection);
    }
}
