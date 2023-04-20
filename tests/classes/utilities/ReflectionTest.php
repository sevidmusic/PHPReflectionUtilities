<?php

namespace Darling\PHPReflectionUtilities\Tests\classes\utilities;

use \ReflectionClass;
use \Darling\PHPTextTypes\classes\strings\ClassString;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPReflectionUtilities\Tests\PHPReflectionUtilitiesTest;
use \Darling\PHPReflectionUtilities\Tests\interfaces\utilities\ReflectionTestTrait;

class ReflectionTest extends PHPReflectionUtilitiesTest
{

    /**
     * The ReflectionTestTrait defines common tests for
     * implementations of the
     * Darling\PHPReflectionUtilities\interfaces\utilities\Reflection
     * interface.
     *
     * @see ReflectionTestTrait
     *
     */
    use ReflectionTestTrait;

    protected function setUp(): void
    {
        $class = $this->randomClassStringOrObjectInstance();
        $classString = new ClassString(
            (
                is_object($class)
                ? $class::class
                : $class
            )
        );
        /**
         * @var class-string $classStringString
         */
        $classStringString = $classString->__toString();
        $this->setClassToBeReflected($classStringString);
        $this->setReflectionTestInstance(
            new Reflection(
                $classString
            )
        );
    }

    /**
     * Set the class or object instance that is expected to
     * be reflected by the Reflection implementation instance
     * being tested.
     *
     * Full documentation of this method can be found in
     * PHPReflectionUtilities/tests/interfaces/utilities/ReflectionTestTrait.php
     *
     * @see https://github.com/sevidmusic/PHPReflectionUtilities/blob/main/tests/interfaces/utilities/ReflectionTestTrait.php
     *
     * @param class-string|object $class The class-string or object
     *                                   instance to be reflected.

     * @return void
     *
     * @example
     *
     * ```
     * $this->setClassToBeReflected($this::class);
     *
     * ```
     *
     */
    protected function setClassToBeReflected(
        string|object $class
    ): void
    {
        $this->reflectedClass = $class;
    }

}

