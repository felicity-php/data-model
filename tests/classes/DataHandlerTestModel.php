<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace tests\classes;

use DateTime;
use DateTimeZone;
use felicity\datamodel\Model;
use felicity\datamodel\ModelCollection;
use felicity\datamodel\services\datahandlers\BoolHandler;
use felicity\datamodel\services\datahandlers\ArrayHandler;

/**
 * Class ModelBasicTestModel
 */
class DataHandlerTestModel extends Model
{
    /** @var string $testArray */
    public $testArray;

    /** @var string $testBool */
    public $testBool;

    /** @var ModelCollection $testCollection */
    public $testCollection;

    /** @var DateTimeZone $testDateTimeZone */
    public $testDateTimeZone = '';

    /** @var DateTime $testDateTime */
    public $testDateTime;

    /** @var string[] $testEmailArray */
    public $testEmailArray;

    /** @var string $testEmail */
    public $testEmail;

    /** @var mixed $testEnum */
    public $testEnum;

    /** @var float[] $testFloatArray */
    public $testFloatArray;

    /** @var float $testFloat */
    public $testFloat;

    /** @var mixed[] $testInstanceArray */
    public $testInstanceArray;

    /** @var mixed $testInstance */
    public $testInstance;

    /** @var int[] $testIntArray */
    public $testIntArray;

    /** @var int $testInt */
    public $testInt;

    /** @var string[] $testStringArray */
    public $testStringArray;

    /** @var string $testString */
    public $testString;

    /**
     * @inheritdoc
     */
    protected function defineHandlers(): array
    {
        return [
            'testArray' => [
                'class' => ArrayHandler::class,
            ],
            'testBool' => [
                'class' => BoolHandler::class,
            ],
        ];
    }
}
