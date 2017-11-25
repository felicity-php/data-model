<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace felicity\datamodel\services\datahandlers;

/**
 * Class BoolHandler
 */
class BoolHandler
{
    /**
     * Casts the value to a boolean
     * @param mixed $val
     * @return bool
     */
    public static function castValue($val) : bool
    {
        return $val === '1' ||
            $val === 1 ||
            $val === 'true' ||
            $val === true ||
            $val === 'y' ||
            $val === 'yes';
    }
}
