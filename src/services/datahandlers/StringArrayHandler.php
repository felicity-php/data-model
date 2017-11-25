<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace felicity\datamodel\services\datahandlers;

/**
 * Class StringArrayHandler
 */
class StringArrayHandler
{
    /**
     * Casts the value
     * @param mixed $val
     * @param array $def
     * @return array|null
     */
    public static function castValue($val, array $def = [])
    {
        // Send data to the array handler to array-ify
        $val = ArrayHandler::castValue($val, $def);

        // If val is null, send null back
        if ($val === null) {
            return null;
        }

        // Prepare return array
        $returnArray = [];

        // Iterate through each of the items and cast to handler
        foreach ($val ?: [] as $item) {
            $item = StringHandler::castValue($item);

            if (! $item) {
                continue;
            }

            $returnArray[] = $item;
        }

        // Return the array
        return $returnArray ?: null;
    }
}
