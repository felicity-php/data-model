<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace felicity\datamodel\services\datahandlers;

/**
 * Class FloatHandler
 */
class FloatHandler
{
    /**
     * Casts the value
     * @param mixed $val
     * @return float|null
     */
    public static function castValue($val)
    {
        if ($val === null) {
            return null;
        }

        return (float) $val;
    }

    /**
     * Validates the value
     * @param mixed $val
     * @param array $def
     * @return array An array of errors
     */
    public static function validateValue($val, array $def = []) : array
    {
        if (! $val && isset($def['required']) && $def['required']) {
            return ['This field is required'];
        }

        if (isset($def['min'])) {
            $min = (float) $def['min'];
            if ($val < $min) {
                return ["This field must not be less than {$min}"];
            }
        }

        if (isset($def['max'])) {
            $max = (float) $def['max'];
            if ($val > $max) {
                return ["This field must not be more than {$max}"];
            }
        }

        return [];
    }
}
