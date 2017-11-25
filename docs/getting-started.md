# Getting Started with Felicity DataModel

## Installing

To begin using DataModel, require it into your project with composer:

```shell
composer require felicity-php/felicity-datamodel
```

## Creating a model

To get started using the DataModel, you create your own model/class which extends the Felicity DataModel `Model` class, set the public properties you wish to have on your model, and define custom handlers to cast and validate your data. Here is a simple example of a model that has an integer property called `myInteger`

```php
<?php

use felicity\datamodel\Model;
use felicity\datamodel\services\datahandlers\IntHandler;

/**
 * Class MyModel
 * @property int $myInteger
 */
class MyModel extends Model
{
    /** @var int $testInt */
    public $myInteger;

    /**
     * @inheritdoc
     */
    protected function defineHandlers(): array
    {
        return [
            'myInteger' => [
                'class' => IntHandler::class,
            ],
        ];
    }
}
```

Now to use this model, you can set your property using the `setProperty` method to make sure the data goes through the casting methods. You can get your property as you would any public property on an object.

```php
$model = new MyModel();
var_dump($model->myInteger); // This will be null since it has not been set yet
$model->setProperty('myInteger', 35);
var_dump($model->myInteger); // Now this will be 35
```

You can also set some basic validation rules.

```php
<?php

use felicity\datamodel\Model;
use felicity\datamodel\services\datahandlers\IntHandler;

/**
 * Class MyModel
 * @property int $myInteger
 */
class MyModel extends Model
{
    /** @var int $testInt */
    public $myInteger;

    /**
     * @inheritdoc
     */
    protected function defineHandlers(): array
    {
        return [
            'myInteger' => [
                'class' => IntHandler::class,
                'required' => true,
                'min' => 2,
                'max' => 10
            ],
        ];
    }
}

$model = new MyModel();
$model->myInteger = 1;
var_dump($model->validate()); // This will be false
var_dump($model->hasErrors()); // This will be true
var_dump($model->getErrors()); // An array where the key is the property with errors and the value is an array of the errors for that property
```

## Collection of models

You can also create a collection of models.

```php
$collection = new \felicity\datamodel\ModelCollection([
    new MyModel([
        'myInteger' => 2
    ]),
    new MyModel([
        'myInteger' => 3
    ]),
]);
```

Collections can be iterated over with `foreach` and counted with `count($collection)`. There are also methods for adding a single model, an array of models setting a new array of models, removing a model, emptying the collection, plucking the value of a specific property from each model in the collection, getting an array of models as array, and ordering the models in the collection by a specific property.
