<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2017 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace felicity\datamodel;

use ReflectionException;

/**
 * Class ModelCollection
 */
class ModelCollection implements \Iterator, \Countable
{
    /** @var Model[] $models */
    private $models = array();

    /** @var array $keysToIndex */
    private $uuidToIndex = array();

    /** @var array $indexToKeys */
    private $indexToUuid = array();

    /** @var int $position */
    private $position = 0;

    /**
     * Constructor
     * @param Model[] $models
     */
    public function __construct(array $models = array())
    {
        // Set any models passed in
        $this->setModels($models);
    }

    /**
     * Rewind
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Current
     * @return Model
     */
    public function current() : Model
    {
        return $this->models[$this->position];
    }

    /**
     * Key
     * @return int
     */
    public function key() : int
    {
        return $this->position;
    }

    /**
     * Next
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Valid
     * @return bool
     */
    public function valid() : bool
    {
        return isset($this->models[$this->position]);
    }

    /**
     * Count
     * @return int
     */
    public function count() : int
    {
        return \count($this->models);
    }

    /**
     * Add model
     * @param Model $model
     * @return self
     */
    public function addModel(Model $model) : ModelCollection
    {
        // Add model indexed by its uuid
        $this->models[] = $model;

        // Re-index models
        $this->uuidToIndex = array();
        $this->indexToUuid = array();
        foreach ($this->models as $key => $loopModel) {
            $this->uuidToIndex[$loopModel->uuid] = $key;
            $this->indexToUuid[$key] = $loopModel->uuid;
        }

        // Return instance
        return $this;
    }

    /**
     * Add models
     * @param Model[] $models
     * @return self
     */
    public function addModels(array $models) : ModelCollection
    {
        // Iterate through models and add them
        foreach ($models as $model) {
            $this->addModel($model);
        }

        // Return instance
        return $this;
    }

    /**
     * Set models
     * @param Model[] $models
     * @return self
     */
    public function setModels($models) : ModelCollection
    {
        // Empty the collection
        $this->emptyCollection();

        // Add the models
        $this->addModels($models);

        // Return instance
        return $this;
    }

    /**
     * Empty the collection
     * @return self
     */
    public function emptyCollection() : ModelCollection
    {
        // Empty the collection
        $this->models = [];

        // Return instance
        return $this;
    }

    /**
     * Remove model
     * @param int|string|Model $model
     * @return self
     */
    public function removeModel($model) : ModelCollection
    {
        // If $model is numeric, delete from the models array
        if (\is_numeric($model)) {
            unset($this->models[$model]);

        // If $model is a string, it is assumed to be the uuid
        } elseif (\is_string($model)) {
            unset($this->models[$this->uuidToIndex[$model]]);

        // If $model is instance of Model, get its uuid and remove
        } elseif ($model instanceof Model) {
            unset($this->models[$this->uuidToIndex[$model->uuid]]);
        }

        // Return instance
        return $this;
    }

    /**
     * Pluck the value of property on all models
     * @param string $prop
     * @return array
     */
    public function pluck($prop) : array
    {
        // Return array
        $returnArray = [];

        // Iterate through each model and get the value
        foreach ($this->models as $model) {
            $returnArray[] = $model->{$prop};
        }

        // Return the array
        return $returnArray;
    }

    /**
     * As array
     * @param bool $excludeUuid
     * @param string|bool $indexedBy
     * @return array
     * @throws ReflectionException
     */
    public function asArray(bool $excludeUuid = false, $indexedBy = 'uuid') : array
    {
        // Return array
        $returnArray = [];

        // Iterate through models and get asArray
        foreach ($this->models as $model) {
            if (\is_string($indexedBy)) {
                $returnArray[$model->{$indexedBy}] = $model->asArray($excludeUuid);
                continue;
            }

            $returnArray[] = $model->asArray($excludeUuid);
        }

        // Return the array
        return $returnArray;
    }

    /**
     * Gets array of all models
     * @param string|bool $indexedBy
     * @return Model[]
     */
    public function getModels($indexedBy = 'uuid') : array
    {
        // Return array
        $returnArray = [];

        // Iterate through models and get asArray
        foreach ($this->models as $model) {
            if (\is_string($indexedBy)) {
                $returnArray[$model->{$indexedBy}] = $model;
                continue;
            }

            $returnArray[] = $model;
        }

        // Return the array
        return $returnArray;
    }

    /**
     * Order models by property
     * @param string $prop
     * @param string $dir
     * @return self
     */
    public function orderBy($prop, $dir = 'asc') : ModelCollection
    {
        // Make sure $dir is acceptable
        $dir = $dir === 'asc' || $dir === 'desc' ? $dir : 'asc';

        // Get array of models indexed by property
        $array = [];

        foreach ($this->models as $model) {
            $array[$model->{$prop}] = $model;
        }

        // Sort the array
        ksort($array);

        // Check the direction
        if ($dir === 'desc') {
            $array = array_reverse($array);
        }

        // Set the models
        $this->setModels(array_values($array));

        // Return instance
        return $this;
    }
}
