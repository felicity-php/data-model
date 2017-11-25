<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace felicity\datamodel\services\datahandlers;

/**
 * Class StringHandler
 */
class StringHandler
{
    /**
     * Casts the value
     * @param mixed $val
     * @return string|null
     */
    public static function castValue($val)
    {
        if ($val === null) {
            return null;
        }

        return (string) $val;
    }
}
