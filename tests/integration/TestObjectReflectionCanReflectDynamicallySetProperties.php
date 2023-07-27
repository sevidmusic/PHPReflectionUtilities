<?php

require(
    str_replace(
        'tests' . DIRECTORY_SEPARATOR . 'integration',
        '',
        __DIR__
    ) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php'
);

use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;

$stdClass = new stdClass();
$stdClass->foo = str_shuffle('abcdefg');
$stdClass->bar = str_shuffle('abcdefg');

$objectReflection = new ObjectReflection($stdClass);

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

if(
    in_array('foo', $objectReflection->propertyNames())
    &&
    in_array('bar', $objectReflection->propertyNames())
    &&
    in_array($stdClass->foo, $objectReflection->propertyValues())
    &&
    in_array($stdClass->bar, $objectReflection->propertyValues())
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}
