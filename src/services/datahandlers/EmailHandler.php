<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace felicity\datamodel\services\datahandlers;

/**
 * Class EmailHandler
 */
class EmailHandler
{
    /**
     * Casts the value
     * @param mixed $val
     * @return string|null
     */
    public static function castValue($val)
    {
        return filter_var($val, FILTER_VALIDATE_EMAIL) ?: null;
    }
}
