<?php

namespace tests\interfaces\utilities;

use \ReflectionProperty;
use Darling\PHPReflectionUtilities\interfaces\utilities\ObjectReflection;
use tests\interfaces\utilities\ReflectionTestTrait;

/**
 * The ObjectReflectionTestTrait defines common tests for
 * implementations of the ObjectReflection interface.
 *
 * @see ObjectReflection
 *
 */
trait ObjectReflectionTestTrait
{

    /**
     * The ReflectionTestTrait defines common tests for
     * implementations of the Darling\PHPReflectionUtilities\interfaces\utilities\Reflection
     * interface.
     *
     * @see ReflectionTestTrait
     *
     */
    use ReflectionTestTrait;

    /**
     * @var object $reflectedObject The object that is expected to be
     *                              reflected by the ObjectReflection
     *                              implementation instance being
     *                              tested.
     */
    private object $reflectedObject;

    /**
     * @var ObjectReflection $objectReflection An instance of a
     *                                         ObjectReflection
     *                                         implementation to
     *                                         test.
     */
    private ObjectReflection $objectReflection;

    /**
     * Set up an instance of a ObjectReflection to test using a
     * random object instance.
     *
     * This method must set the object instance that is expected
     * to be reflected by the ObjectReflection implementation
     * instance to test via the setClassToBeReflected(), and
     * setObjectToBeReflected() methods.
     *
     * This method must also set the ObjectReflection implementation
     * instance to test via the setReflectionTestInstance(), and
     * setObjectReflectionTestInstance() methods.
     *
     * This method may perform any additional set up required by
     * the ObjectReflection implementation being tested.
     *
     * @return void
     *
     * @example
     *
     * ```
     * protected function setUp(): void
     * {
     *     $object = $this->randomObjectInstance();
     *     $this->setClassToBeReflected($object);
     *     $this->setObjectToBeReflected($object);
     *     $objectReflection =
     *         new \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection($object);
     *     $this->setReflectionTestInstance($objectReflection);
     *     $this->setObjectReflectionTestInstance($objectReflection);
     * }
     *
     * ```
     *
     */
    abstract protected function setUp(): void;

    /**
     * Set the object that is expected to be reflected by the
     * ObjectReflection implementation instance being tested.
     *
     * @return void
     *
     * @example
     *
     * ```
     * $this->setObjectToBeReflected(new \stdClass());
     *
     * ```
     *
     */
    protected function setObjectToBeReflected(object $object): void
    {
        $this->reflectedObject = $object;
    }

    /**
     * Return the ObjectReflection implementation instance to test.
     *
     * @return ObjectReflection
     *
     * @example
     *
     * ```
     *
     * ```
     *
     */
    protected function objectReflectionTestInstance(): ObjectReflection
    {
        return $this->objectReflection;
    }

    /**
     * Return the object that is expected to be reflected by the
     * ObjectReflection implementation instance being tested.
     *
     * @return object
     *
     * @example
     *
     * ```
     *
     * ```
     *
     */
    private function reflectedObject(): object
    {
        return $this->reflectedObject;
    }

    /**
     * Return an associatively indexed array of the values
     * of the properties defined by the object reflected by
     * the ObjectReflection implementation instance being
     * tested indexed by property name.
     *
     * Note: Uninitialized properties will be assigned the value null.
     *
     * @return array<string, mixed>
     *
     * @example
     *
     * ```
     *
     * ```
     *
     */
    protected function determineReflectedClassesPropertyValues(): array
    {
        $reflectionClass = $this->reflectionClass(
            $this->reflectedObject()
        );
        $properties = $reflectionClass->getProperties();
        $propertyValues = array();
        foreach ($properties as $property) {
            $this->addPropertyValueToArray(
                $property,
                $this->reflectedObject(),
                $propertyValues
            );
        }
        $this->addParentPropertyValuesToArray(
            $this->reflectedObject(),
            $propertyValues
        );
        return $propertyValues;
    }

    /**
     * Add the values of the properties defined by the parent
     * classes of the specified object to the specified array.
     *
     * Index the values by the name of the property they are
     * assigned to.
     *
     * Note: If the specified array already contains a value indexed
     * under the name of one of the parent properties, the existing
     * value will be preserved, and the parent property's value will
     * not be added to the array.
     *
     * Note: Uninitialized properties will be assigned the value null.
     *
     * @param array<string, mixed> $propertyValues The array to add
     *                                             the property
     *                                             values to.
     *
     * @return void
     *
     * @example
     *
     * ```
     *
     * ```
     *
     */
    private function addParentPropertyValuesToArray(
        object $object,
        array &$propertyValues
    ): void
    {
        $reflectionClass = $this->reflectionClass($object);
        while($parent = $reflectionClass->getParentClass()) {
            foreach($parent->getProperties() as $property) {
                if(!isset($propertyValues[$property->getName()])) {
                    $this->addPropertyValueToArray(
                        $property,
                        $object,
                        $propertyValues
                    );
                }
            }
            $reflectionClass = $parent;
        }
    }

    /**
     * Add the value of the specified property to the specified
     * array.
     *
     * Index the values by the name of the property they are
     * assigned to.
     *
     * @param ReflectionProperty $property An instance of a
     *                                     ReflectionProperty that
     *                                     reflects the target
     *                                     property.
     *
     * @param object $object The object instance that defined the
     *                       property.
     *
     * @param array<string, mixed> $propertyValues The array to add
     *                                             the property's
     *                                             value to.
     *
     * @return void
     *
     * @example
     *
     * ```
     *
     * ```
     *
     */
    private function addPropertyValueToArray(
        ReflectionProperty $property,
        object $object,
        array &$propertyValues
    ): void
    {
        if($property->isInitialized($object)) {
            $property->setAccessible(true);
            $propertyValues[$property->getName()] =
                $property->getValue($object);
        } else{
            $propertyValues[$property->getName()] =
                null;
        }
    }

    /**
     * Set the ObjectReflection implementation instance to test.
     *
     * @param ObjectReflection $objectReflectionTestInstance
     *                              An instance of an
     *                              implementation of
     *                              the ObjectReflection
     *                              interface to test.
     *
     * @return void
     *
     * @example
     *
     * ```
     *
     * ```
     *
     */
    protected function setObjectReflectionTestInstance(
        ObjectReflection $objectReflectionTestInstance
    ): void
    {
        $this->objectReflection = $objectReflectionTestInstance;
    }

    /**
     * Test that the propertyValues() method returns an
     * associatively indexed array of the values of the
     * properties defined by the reflected object indexed
     * by property name.
     *
     * @return void
     *
     */
    public function test_propertyValues_returns_the_values_of_the_properties_defined_by_the_reflected_object(): void
    {
        $this->assertEquals(
            $this->determineReflectedClassesPropertyValues(),
            $this->objectReflectionTestInstance()->propertyValues(),
            $this->testFailedMessage(
                $this->objectReflectionTestInstance(),
                'propertyValues',
                'return an associatively indexed array of the ' .
                'values of the properties defined by the ' .
                'reflected object indexed by property name'
            )
        );
    }

    /**
     * Test that the reflectedObject() method returns the reflected
     * object instance.
     *
     * @return void
     *
     */
    public function test_reflectedObject_returns_the_reflected_object_instance(): void
    {
        $this->assertEquals(
            $this->reflectedObject(),
            $this->objectReflectionTestInstance()->reflectedObject(),
            $this->testFailedMessage(
                $this->objectReflectionTestInstance(),
                'reflectedObject',
                'return the reflected object instance'
            )
        );
    }
}

