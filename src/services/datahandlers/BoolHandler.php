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
     * @return bool|null
     */
    public static function castValue($val)
    {
        if ($val === null) {
            return null;
        }

        return $val === '1' ||
            $val === 1 ||
            $val === 'true' ||
            $val === true ||
            $val === 'y' ||
            $val === 'yes';
    }

    /**
     * Validates the value
     * @param mixed $val
     * @param array $def
     * @return array An array of errors
     */
    public static function validateValue($val, array $def = []) : array
    {
        if (! \is_bool($val) &&
            isset($def['required']) &&
            $def['required']
        ) {
            return ['This field is required'];
        }

        return [];
    }
}
