<?php

namespace Darling\PHPReflectionUtilities\interfaces\strings;

use Darling\PHPReflectionUtilities\interfaces\strings\Text;

/**
 * A ClassString is the name of an existing Class prefixed by
 * it's namespace.
 *
 * @example
 *
 * ```
 * echo $classString;
 * // example output: Darling\PHPReflectionUtilities\classes\strings\ClassString
 *
 * ```
 *
 * @see Text
 *
 */
interface ClassString extends Text
{

    /**
     * Return the name of an existing Class prefixed by it's
     * namespace.
     *
     * @return class-string
     *
     * @example
     *
     * ```
     * echo $classString->__toString();
     * // example output: Darling\PHPReflectionUtilities\classes\strings\ClassString
     *
     * ```
     *
     */
    public function __toString(): string;

}

