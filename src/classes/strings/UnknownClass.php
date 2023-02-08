<?php

namespace Darling\PhpReflectionUtilities\classes\strings;

use Darling\PhpReflectionUtilities\interfaces\strings\UnknownClass as UnknownClassInterface;

use Darling\PhpReflectionUtilities\classes\strings\ClassString;

final class UnknownClass extends ClassString implements UnknownClassInterface
{

    /**
     * Instantiate a new UnknownClass instance.
     *
     * @example
     *
     * ```
     * $text = new UnknownClass();
     *
     * echo $unknownClass;
     * // example output: Darling\PhpReflectionUtilities\classes\strings\UnknownClass
     *
     * ```
     *
     */
    public function __construct()
    {
        parent::__construct(get_class($this));
    }

}

