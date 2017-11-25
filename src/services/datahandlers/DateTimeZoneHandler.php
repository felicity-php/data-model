<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace felicity\datamodel\services\datahandlers;

use Exception;
use DateTimeZone;

/**
 * Class DateTimeZoneHandler
 */
class DateTimeZoneHandler
{
    /**
     * Casts the value to an array
     * @param mixed $val
     * @return DateTimeZone|null
     */
    public static function castValue($val)
    {
        if ($val instanceof DateTimeZone) {
            return $val;
        }

        try {
            return new DateTimeZone($val);
        } catch (Exception $e) {
            return null;
        }
    }
}
