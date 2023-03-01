<?php

require __DIR__ . '/vendor/autoload.php';

use Darling\PHPReflectionUtilities\classes\utilities\Reflection;

$reflection = new Reflection(new \ReflectionClass(Reflection::class));

var_dump($reflection->type()->__toString());

var_dump($reflection->methodNames(Reflection::IS_PUBLIC));

var_dump($reflection->methodParameterNames('methodParameterNames'));

var_dump($reflection->methodParameterTypes('methodParameterTypes'));

var_dump($reflection->propertyNames(Reflection::IS_PRIVATE));

var_dump($reflection->propertyTypes(Reflection::IS_PRIVATE));

var_dump($reflection->type());
