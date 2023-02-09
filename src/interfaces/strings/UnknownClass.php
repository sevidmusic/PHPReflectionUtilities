<?php

namespace Darling\PHPReflectionUtilities\interfaces\strings;

use Darling\PHPReflectionUtilities\interfaces\strings\ClassString;

/**
 * An UnknownClass is a ClassString that represents an unknown class.
 *
 * @example
 *
 * ```
 * echo $unknownClass;
 * // example output: Darling\PHPReflectionUtilities\classes\strings\UnknownClass
 *
 * ```
 *
 * @see ClassString
 *
 */
interface UnknownClass extends ClassString
{

    /**
     * Return Darling\PHPReflectionUtilities\classes\strings\UnknownClass
     *
     * @return string
     *
     * @example
     *
     * ```
     * echo $unknownClass->__toString();
     * // example output: Darling\PHPReflectionUtilities\classes\strings\UnknownClass
     *
     * ```
     *
     */
    public function __toString(): string;

}

