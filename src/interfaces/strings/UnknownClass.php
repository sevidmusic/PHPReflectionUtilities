<?php

namespace Darling\PhpReflectionUtilities\interfaces\strings;

use Darling\PhpReflectionUtilities\interfaces\strings\ClassString;

/**
 * An UnknownClass is a ClassString that represents an unknown class.
 *
 * @example
 *
 * ```
 * echo $unknownClass;
 * // example output: Darling\PhpReflectionUtilities\classes\strings\UnknownClass
 *
 * ```
 *
 * @see ClassString
 *
 */
interface UnknownClass extends ClassString
{

    /**
     * Return Darling\PhpReflectionUtilities\classes\strings\UnknownClass
     *
     * @return string
     *
     * @example
     *
     * ```
     * echo $unknownClass->__toString();
     * // example output: Darling\PhpReflectionUtilities\classes\strings\UnknownClass
     *
     * ```
     *
     */
    public function __toString(): string;

}

