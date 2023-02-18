<?php

require __DIR__ . '/vendor/autoload.php';

use Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;

$arrayIterator = new ArrayIterator(array('test1', 'test2', 'test3'));

$instanceToReflect = new RegexIterator(
    $arrayIterator,
    '/^(test)(\d+)/',
    RegexIterator::REPLACE
);

$objectReflection = new ObjectReflection($instanceToReflect);

var_dump($objectReflection->propertyValues());

var_dump($objectReflection->methodNames());

