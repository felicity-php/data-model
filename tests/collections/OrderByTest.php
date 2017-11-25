<?php

namespace tests\collections;

use PHPUnit\Framework\TestCase;
use tests\classes\ModelBasicTestModel;
use felicity\datamodel\ModelCollection;

/**
 * Class OrderByTest
 */
class OrderByTest extends TestCase
{
    /**
     * Test iterator
     */
    public function test()
    {
        $model1 = new ModelBasicTestModel([
            'testProp1' => 'abc',
            'testProp2' => 2
        ]);
        $model2 = new ModelBasicTestModel([
            'testProp1' => 'def',
            'testProp2' => 1
        ]);
        $items = array($model1, $model2);
        $collection = new ModelCollection($items);

        $collection->orderBy('testProp1', 'desc');
        $i = 0;
        foreach ($collection as $model) {
            if ($i === 0) {
                self::assertEquals($model2->uuid, $model->uuid);
            } elseif ($i === 1) {
                self::assertEquals($model1->uuid, $model->uuid);
            }

            $i++;
        }

        $collection->orderBy('testProp1', 'asc');
        $i = 0;
        foreach ($collection as $model) {
            if ($i === 0) {
                self::assertEquals($model1->uuid, $model->uuid);
            } elseif ($i === 1) {
                self::assertEquals($model2->uuid, $model->uuid);
            }

            $i++;
        }

        $collection->orderBy('testProp1');
        $i = 0;
        foreach ($collection as $model) {
            if ($i === 0) {
                self::assertEquals($model1->uuid, $model->uuid);
            } elseif ($i === 1) {
                self::assertEquals($model2->uuid, $model->uuid);
            }

            $i++;
        }

        $collection->orderBy('testProp2');
        $i = 0;
        foreach ($collection as $model) {
            if ($i === 0) {
                self::assertEquals($model2->uuid, $model->uuid);
            } elseif ($i === 1) {
                self::assertEquals($model1->uuid, $model->uuid);
            }

            $i++;
        }

        $collection->orderBy('testProp2', 'desc');
        $i = 0;
        foreach ($collection as $model) {
            if ($i === 0) {
                self::assertEquals($model1->uuid, $model->uuid);
            } elseif ($i === 1) {
                self::assertEquals($model2->uuid, $model->uuid);
            }

            $i++;
        }
    }
}
