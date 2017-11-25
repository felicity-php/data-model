<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace felicity\datamodel\services\generators;

/**
 * Class Uuid
 */
class UuidGenerator
{
    /**
     * Generate a uuid
     * @return string
     */
    public function generate()
    {
        return sha1(microtime(true) . mt_rand(10000, 90000));
    }

    /**
     * Generate a uuid
     * @return string
     */
    public static function generateUuid()
    {
        return sha1(microtime(true) . mt_rand(10000, 90000));
    }
}
