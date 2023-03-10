<?php

namespace tests\classes\utilities;

use \ReflectionClass;
use Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use tests\PHPReflectionUtilitiesTest;
use tests\interfaces\utilities\ReflectionTestTrait;

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
        $this->setClassToBeReflected($class);
        $this->setReflectionTestInstance(
            new Reflection(
                $this->reflectionClass($class)
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

