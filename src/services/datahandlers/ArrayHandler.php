<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace felicity\datamodel\services\datahandlers;

/**
 * Class ArrayHandler
 */
class ArrayHandler
{
    /**
     * Generate a uuid
     * @param mixed $val
     * @param array $def
     * @return array
     */
    public static function castValue($val, array $def = array()) : array
    {
        // Check if incoming value is a string
        if (\is_string($val)) {
            // If it is a string, find the explode operator
            $explodeOn = $def['explodeOn'] ?? '|';

            // Explode on the value to create our array
            $val = explode($explodeOn, $val);

        // Otherwise if the value is something other than an array
        } elseif (! \is_array($val)) {
            $val = [
                $val,
            ];
        }

        // Return the value
        return $val;
    }
}
