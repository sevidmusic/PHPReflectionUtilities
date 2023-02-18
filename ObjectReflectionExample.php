<?php

require __DIR__ . '/vendor/autoload.php';

use Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;

$instanceToReflect = new ArrayIterator(array('test1', 'test2', 'test3'));

$objectReflection = new ObjectReflection($instanceToReflect);

var_dump($objectReflection->propertyValues());

var_dump($objectReflection->methodNames());

