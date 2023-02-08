<?php

namespace tests\classes\utilities;

use Darling\PhpReflectionUtilities\classes\utilities\ObjectReflection;
use tests\RoadyTest;
use tests\classes\utilities\ReflectionTest;
use tests\interfaces\utilities\ObjectReflectionTestTrait;

class ObjectReflectionTest extends ReflectionTest
{

    /**
     * The ObjectReflectionTestTrait defines
     * common tests for implementations of the
     * Darling\PhpReflectionUtilities\interfaces\utilities\ObjectReflection
     * interface.
     *
     * @see ObjectReflectionTestTrait
     *
     */
    use ObjectReflectionTestTrait;

    protected function setUp(): void
    {
        $object = $this->randomObjectInstance();
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

