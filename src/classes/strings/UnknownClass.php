<?php

namespace Darling\PHPReflectionUtilities\classes\strings;

use Darling\PHPReflectionUtilities\interfaces\strings\UnknownClass as UnknownClassInterface;

use Darling\PHPReflectionUtilities\classes\strings\ClassString;

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
     * // example output: Darling\PHPReflectionUtilities\classes\strings\UnknownClass
     *
     * ```
     *
     */
    public function __construct()
    {
        parent::__construct(get_class($this));
    }

}

