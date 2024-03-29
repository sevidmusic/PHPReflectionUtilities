<?php

namespace Darling\PHPReflectionUtilities\Tests\classes\utilities;

use Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;
use Darling\PHPReflectionUtilities\Tests\PHPReflectionUtilitiesTest;
use Darling\PHPReflectionUtilities\Tests\classes\utilities\ReflectionTest;
use Darling\PHPReflectionUtilities\Tests\interfaces\utilities\ObjectReflectionTestTrait;

class ObjectReflectionTest extends ReflectionTest
{

    /**
     * The ObjectReflectionTestTrait defines
     * common tests for implementations of the
     * Darling\PHPReflectionUtilities\interfaces\utilities\ObjectReflection
     * interface.
     *
     * @see ObjectReflectionTestTrait
     *
     */
    use ObjectReflectionTestTrait;

    protected function setUp(): void
    {
        $stdClass = new \stdClass();
        $stdClass->foo = str_shuffle('abcdefg');
        $stdClass->bar = str_shuffle('abcdefg');
        $objects = [
            $this->randomObjectInstance(),
            $stdClass,
        ];
        $object = $objects[array_rand($objects)];
        $this->setClassToBeReflected($object);
        $this->setObjectToBeReflected($object);
        $objectReflection = new ObjectReflection($object);
        $this->setReflectionTestInstance($objectReflection);
        $this->setObjectReflectionTestInstance($objectReflection);
    }

    protected function setClassToBeReflected(
        string|object $class
    ): void
    {
        $this->reflectedClass = $class;
    }

}

