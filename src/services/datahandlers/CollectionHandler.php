<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace felicity\datamodel\services\datahandlers;

use felicity\datamodel\ModelCollection;

/**
 * Class CollectionHandler
 */
class CollectionHandler
{
    /**
     * Casts the value to a boolean
     * @param mixed $val
     * @return bool|null
     */
    public static function castValue($val)
    {
        if (! $val instanceof ModelCollection) {
            return null;
        }

        // Since the value is an instance of ModelCollection, return it
        return $val;
    }
}
