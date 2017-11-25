<?php

namespace tests\collections;

use PHPUnit\Framework\TestCase;
use tests\classes\ModelBasicTestModel;
use felicity\datamodel\ModelCollection;

/**
 * Class AddModelTest
 */
class AddModelTest extends TestCase
{
    /**
     * Test add model
     */
    public function testAddModel()
    {
        $collection = new ModelCollection();

        self::assertCount(0, $collection);

        $collection->addModel(new ModelBasicTestModel());
        self::assertCount(1, $collection);

        $collection->addModel(new ModelBasicTestModel());
        self::assertCount(2, $collection);
    }

    /**
     * Test add models
     */
    public function testAddModels()
    {
        $items = [
            new ModelBasicTestModel(),
            new ModelBasicTestModel()
        ];

        $items2 = [
            new ModelBasicTestModel(),
            new ModelBasicTestModel(),
            new ModelBasicTestModel()
        ];

        $collection = new ModelCollection();

        $collection->addModels($items);
        self::assertCount(2, $collection);

        $collection->addModels($items2);
        self::assertCount(5, $collection);
    }

    /**
     * Test set models
     */
    public function testSetModels()
    {
        $items = [
            new ModelBasicTestModel(),
            new ModelBasicTestModel()
        ];

        $items2 = [
            new ModelBasicTestModel(),
            new ModelBasicTestModel(),
            new ModelBasicTestModel()
        ];

        $collection = new ModelCollection();

        $collection->setModels($items);
        self::assertCount(2, $collection);

        $collection->setModels($items2);
        self::assertCount(3, $collection);
    }
}
