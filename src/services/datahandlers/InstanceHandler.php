<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace felicity\datamodel\services\datahandlers;

/**
 * Class InstanceHandler
 */
class InstanceHandler
{
    /**
     * Casts the value
     * @param mixed $val
     * @param array $def
     * @return float|null
     */
    public static function castValue($val, array $def = [])
    {
        // Make sure our instance def exists and the val is an instance of it
        if (! isset($def['expect']) || ! $val instanceof $def['expect']) {
            return null;
        }

        // Since the value is an instance of expected, return it
        return $val;
    }
}
