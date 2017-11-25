<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace felicity\datamodel\services\datahandlers;

/**
 * Class EnumHandler
 */
class EnumHandler
{
    /**
     * Casts the value
     * @param mixed $val
     * @param array $def
     * @return mixed|null
     */
    public static function castValue($val, array $def = array())
    {
        // Make sure our instance def exists and is array and val in array
        if (! isset($def['expect']) ||
            ! \is_array($def['expect']) ||
            ! \in_array($val, $def['expect'], true)
        ) {
            return null;
        }

        // Since the value is enumerated, return it
        return $val;
    }
}
