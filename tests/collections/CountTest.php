<?php

namespace tests\collections;

use PHPUnit\Framework\TestCase;
use tests\classes\ModelBasicTestModel;
use felicity\datamodel\ModelCollection;

/**
 * Class CountTest
 */
class CountTest extends TestCase
{
    /**
     * Test count
     */
    public function testCount()
    {
        $items = [
            new ModelBasicTestModel(),
            new ModelBasicTestModel()
        ];

        $collection = new ModelCollection($items);

        self::assertCount(2, $collection);
        self::assertEquals(2, $collection->count());

        $items[] = new ModelBasicTestModel();
        $collection->setModels($items);

        self::assertCount(3, $collection);
        self::assertEquals(3, $collection->count());

        $collection->setModels(array());

        self::assertCount(0, $collection);
        self::assertEquals(0, $collection->count());
    }
}
