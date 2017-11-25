<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace felicity\datamodel;

use ReflectionClass;
use ReflectionException;
use felicity\datamodel\services\generators\UuidGenerator;

/**
 * Class Model
 */
abstract class Model
{
    /** @var string $uuid */
    public $uuid = '';

    /** @var array $handlers */
    private $handlers = [];

    /** @var array $errors */
    private $errors = array();

    /**
     * Creates and instance of Model
     * @param array $properties
     * @throws ReflectionException
     */
    public function __construct(array $properties = array())
    {
        // Create the UUID for this model
        $this->uuid = UuidGenerator::generateUuid();

        // Set the handlers
        $this->setHandlers($this->defineHandlers());

        // Set properties
        $this->setProperties($properties);
    }

    /**
     * Clones the Model instance
     */
    public function __clone()
    {
        // Create a new UUID for the cloned model
        $this->uuid = UuidGenerator::generateUuid();
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
     * Gets the defined properties
     * @return array
     * @throws ReflectionException
     */
    public function getDefinedProperties() : array
    {
        // Get a reflection class for this object
        $ref = new ReflectionClass($this);

        $returnArray = [];

        // Iterate through the public properties and put them in the array
        foreach ($ref->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
            $returnArray[] = $prop->name;
        }

        return $returnArray;
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
    public function setProperties(array $properties = array()) : self
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
    public function setProperty(string $name, $val) : self
    {
        // Check if the property is public
        if (! $this->hasProperty($name)) {
            return $this;
        }

        // Set the property
        $this->{$name} = $val;

        // Cast the value
        $this->castValues([$name]);

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

        // Run cast values
        $this->castValues([$name]);

        // Return the value of the property
        return $this->{$name};
    }

    /**
     * Defines property handlers
     * @return array
     */
    protected function defineHandlers() : array
    {
        return [];
    }

    /**
     * Gets the handlers
     * @return array
     */
    public function getHandlers() : array
    {
        return $this->handlers;
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

    /**
     * Sets property handlers
     * @param array $handlers
     * @return self
     */
    public function setHandlers(array $handlers) : Model
    {
        foreach ($handlers as $prop => $handlerConfig) {
            $this->setHandler($prop, $handlerConfig);
        }

        return $this;
    }

    /**
     * Sets a property's handler
     * @param string $prop
     * @param mixed $handlerConfig
     * @return self
     */
    public function setHandler(string $prop, $handlerConfig) : self
    {
        $this->handlers[$prop] = $handlerConfig;

        return $this;
    }

    /**
     * Unsets handlers for specified propertie(s)
     * @param array :
     * @return self
     */
    public function unsetHandlers(array $props) : self
    {
        foreach ($props as $prop) {
            $this->unsetHandler($prop);
        }

        return $this;
    }

    /**
     * Unsets the handler for the specified property
     * @param string $prop
     * @return self
     */
    public function unsetHandler(string $prop) : self
    {
        if (isset($this->handlers[$prop])) {
            unset($this->handlers[$prop]);
        }

        return $this;
    }

    /**
     * Casts the model's values
     * @param array $props
     * @return self
     * @throws ReflectionException
     */
    public function castValues(array $props = []) : self
    {
        $props = $props ?: $this->getDefinedProperties();

        foreach ($props as $prop) {
            // Check if this property is a thing
            if (! $this->hasProperty($prop)) {
                continue;
            }

            // Get the potential custom casting method name
            $customMethod = 'cast' . ucfirst($prop);

            // Check if there's a handler class and method
            if (isset($this->handlers[$prop]['class']) &&
                class_exists($this->handlers[$prop]['class']) &&
                method_exists($this->handlers[$prop]['class'], 'castValue')
            ) {
                // Run the method
                $this->{$prop} = \call_user_func(
                    [
                        $this->handlers[$prop]['class'],
                        'castValue',
                    ],
                    $this->{$prop},
                    $this->handlers[$prop]
                );
            }

            // Check if there's a custom handler method
            if (method_exists($this, $customMethod)) {
                // Run the specified method to cast the value
                $this->{$prop} = $this->{$customMethod}($this->{$prop});
            }
        }

        return $this;
    }

    /**
     * Validates the model
     * @return bool
     * @throws ReflectionException
     */
    public function validate() : bool
    {
        // Set up the errors array
        $errors = [];

        // Run casters
        $this->castValues();

        // Iterate through model properties
        foreach ($this->getDefinedProperties() as $prop) {
            $val = $this->{$prop};
            $def = $this->handlers[$prop] ?? [];

            // Get the potential custom validation method name
            $customMethod = 'validate' . ucfirst($prop);

            // Check if there is a custom validation method
            if (method_exists($this, $customMethod)) {
                // Run specified method to get validation errors
                $validationErrors = $this->{$customMethod}($val, $def);

                // Set validation errors if there are any
                if ($validationErrors) {
                    $errors[$prop] = $validationErrors;
                }

                // Custom method handled it for us, continue
                continue;
            }

            // Check if there's a custom handler class and validation method
            if (isset($this->handlers[$prop]['class']) &&
                class_exists($this->handlers[$prop]['class']) &&
                method_exists($this->handlers[$prop]['class'], 'validateValue')
            ) {
                // Run validation method
                $validationErrors = \call_user_func(
                    [
                        $this->handlers[$prop]['class'],
                        'validateValue',
                    ],
                    $this->{$prop},
                    $this->handlers[$prop]
                );

                // Set validation errors if there are any
                if ($validationErrors) {
                    $errors[$prop] = $validationErrors;
                }

                // Class handled validation for us, go to next
                continue;
            }

            // Since there was no custom handler, validate if required
            if (! $val && isset($def['required']) && $def['required']) {
                $errors[$prop][] = 'This field is required';
            }
        }

        // Set the errors
        $this->errors = $errors;

        // Return result
        return ! $this->hasErrors();
    }

    /**
     * Checks if model has errors
     * @return bool
     */
    public function hasErrors() : bool
    {
        return \count($this->errors) !== 0;
    }

    /**
     * Get errors
     * @return array
     */
    public function getErrors() : array
    {
        return $this->errors;
    }

    /**
     * Adds error to property
     * @param string $prop
     * @param string $message
     * @return self
     * @throws ReflectionException
     */
    public function addError(string $prop, string $message) : self
    {
        // Make sure the specified property is available on the model
        if (! $this->hasProperty($prop)) {
            return $this;
        }

        // Start off with an empty array for existing errors
        $attrErrors = array();

        // If the model already has errors for this attribute, get them
        if (isset($this->errors[$prop])) {
            $attrErrors = $this->errors[$prop];
        }

        // Add the error to the array
        $attrErrors[] = $message;

        // Add the errors to the model
        $this->errors[$prop] = $attrErrors;

        return $this;
    }
}
