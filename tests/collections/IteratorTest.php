<?php

namespace tests\collections;

use PHPUnit\Framework\TestCase;
use tests\classes\ModelBasicTestModel;
use felicity\datamodel\ModelCollection;

/**
 * Class ModelCollectionIteratorTest
 */
class IteratorTest extends TestCase
{
    /**
     * Test iterator
     */
    public function testIterator()
    {
        $items = [
            new ModelBasicTestModel(),
            new ModelBasicTestModel()
        ];

        $collection = new ModelCollection($items);

        $array = array();

        foreach ($collection as $model) {
            $array[] = $model->uuid;
        }

        self::assertCount(2, $array);

        self::assertNotEquals($array[0], $array[1]);
    }
}
