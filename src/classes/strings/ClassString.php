<?php

namespace Darling\PhpReflectionUtilities\classes\strings;

use Darling\PhpReflectionUtilities\classes\strings\Text;
use Darling\PhpReflectionUtilities\classes\strings\UnknownClass;
use Darling\PhpReflectionUtilities\interfaces\strings\ClassString as ClassStringInterface;
use Darling\PhpReflectionUtilities\interfaces\strings\Text as TextInterface;

class ClassString extends Text implements ClassStringInterface
{

    /**
     * Instantiate a new ClassString instance.
     *
     * @param object|string $classString An object instance,
     *                                   or the fully qualified
     *                                   namespace and class name
     *                                   of an existing class.
     *
     * @example
     *
     * ```
     * $obj = (object) array('propertyName' => 'value');
     *
     * $classString = new \Darling\PhpReflectionUtilities\classes\strings\ClassString($obj);
     *
     * echo $classString;
     * // example output: stdClass
     *
     * $classString = new \Darling\PhpReflectionUtilities\classes\strings\ClassString(
     *                    $classString
     *                );
     *
     * echo $classString;
     * // example output: Darling\PhpReflectionUtilities\classes\strings\ClassString
     *
     * ```
     *
     */
    public function __construct(object|string $classString)
    {
        parent::__construct($this->getClass($classString));
    }

    /**
     * Determine the fully qualified namespace and class name of
     * a specified class or object.
     *
     * If the specified class does not exist, then the following
     * fully qualified namespace and class name will be returned:
     *
     * Darling\PhpReflectionUtilities\classes\strings\UnknownClass
     *
     * @return string
     *
     * @example
     *
     * ```
     * echo $this->getClass($this);
     * // example output: Darling\PhpReflectionUtilities\classes\strings\ClassString
     *
     * echo $this->getClass($this::class);
     * // example output: Darling\PhpReflectionUtilities\classes\strings\ClassString
     *
     * echo $this->getClass('invalidClass');
     * // example output: Darling\PhpReflectionUtilities\classes\strings\UnknownClass
     *
     * ```
     *
     */
    private function getClass(object|string $classString): string
    {
        $classString = (
            is_object($classString) ?
            get_class($classString) :
            $classString
        );
        return (
            class_exists($classString)
            ? $classString
            : UnknownClass::class
        );
    }

}

