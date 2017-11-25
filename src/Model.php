<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace felicity\datamodel;

use ReflectionClass;
use ReflectionException;
use felicity\datamodel\services\generators\Uuid;

/**
 * Class Model
 */
abstract class Model
{
    /** @var string $uuid */
    public $uuid = '';

    /**
     * Creates and instance of Model
     * @param array $properties
     * @throws ReflectionException
     */
    public function __construct(array $properties = array())
    {
        $this->uuid = Uuid::generateUuid();

        // Set properties
        $this->setProperties($properties);
    }

    /**
     * Clones the Model instance
     */
    public function __clone()
    {
        $this->uuid = Uuid::generateUuid();
    }

    /**
     * Checks if a property isset
     * @param string $name
     * @return bool
     * @throws ReflectionException
     */
    public function __isset(string $name) : bool
    {
        return $this->hasProperty($name);
    }

    /**
     * Checks if model has property
     * @param string $name
     * @return bool
     * @throws ReflectionException
     */
    public function hasProperty(string $name) : bool
    {
        // Get a reflection class for this object
        $ref = new ReflectionClass($this);

        // Check if this model has the specified property
        if (! $ref->hasProperty($name)) {
            return false;
        }

        // Get the property
        $prop = $ref->getProperty($name);

        // Check if the property is public
        if (! $prop->isPublic()) {
            return false;
        }

        // Model has property
        return true;
    }

    /**
     * Set attributes
     * @param array $properties
     * @return self
     * @throws ReflectionException
     */
    public function setProperties(array $properties = array()) : Model
    {
        // Make sure incoming properties var is iterable
        if (! \is_array($properties)) {
            return $this;
        }

        // Go through each property, and if it is a defined attribute, set it
        foreach ($properties as $name => $val) {
            // Set the property
            $this->setProperty($name, $val);
        }

        // Return instance
        return $this;
    }

    /**
     * Sets a model property
     * @param string $name
     * @param mixed $val
     * @return self
     * @throws ReflectionException
     */
    public function setProperty(string $name, $val) : Model
    {
        // Check if the property is public
        if (! $this->hasProperty($name)) {
            return $this;
        }

        // Set the property
        $this->{$name} = $val;

        return $this;
    }

    /**
     * Gets a model property
     * @param string $name
     * @return mixed
     * @throws ReflectionException
     */
    public function getProperty(string $name)
    {
        // Check if the property is public
        if (! $this->hasProperty($name)) {
            return null;
        }

        // Return the value of the property
        return $this->{$name};
    }

    /**
     * Defines property handlers
     * @return array
     */
    public function defineHandlers() : array
    {
        return [];
    }

    /**
     * Returns the model's properties as an array
     * @param bool $excludeUuid
     * @return array
     * @throws ReflectionException
     */
    public function asArray(bool $excludeUuid = false) : array
    {
        // Create an array for the return values
        $returnArray = [];

        // Get a reflection class for this object
        $ref = new ReflectionClass($this);

        // Iterate through the public properties and put them in the array
        foreach ($ref->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
            $returnArray[$prop->name] = $this->getProperty($prop->name);
        }

        // Remove the uuid if requested
        if ($excludeUuid) {
            unset($returnArray['uuid']);
        }

        // Return the array
        return $returnArray;
    }
}
