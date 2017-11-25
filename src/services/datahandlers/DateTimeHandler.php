<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace felicity\datamodel\services\datahandlers;

use DateTime;
use Exception;

/**
 * Class DateTimeHandler
 */
class DateTimeHandler
{
    /**
     * Casts the value
     * @param mixed $val
     * @return DateTime|null
     */
    public static function castValue($val)
    {
        if ($val instanceof DateTime) {
            return $val;
        }

        $dateTime = null;

        if (self::isValidTimeStamp($val)) {
            $dateTime = new \DateTime();
            $dateTime->setTimestamp($val);
        }

        if (! $dateTime && \is_string($val)) {
            try {
                $dateTime = new \DateTime($val);
            } catch (\Exception $e) {
            }
        }

        return $dateTime;
    }

    /**
     * Check if input is a valid timestamp
     * @param $timestamp
     * @return bool
     */
    private static function isValidTimeStamp($timestamp)
    {
        if (! is_numeric($timestamp)) {
            return false;
        }

        $timestamp = (int) $timestamp;

        try {
            return ($timestamp <= PHP_INT_MAX) && ($timestamp >= ~PHP_INT_MAX);
        } catch (Exception $e) {
            return false;
        }
    }
}
