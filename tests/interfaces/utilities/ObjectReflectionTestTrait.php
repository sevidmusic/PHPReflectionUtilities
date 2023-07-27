<?php

namespace Darling\PHPReflectionUtilities\Tests\interfaces\utilities;

use \ReflectionProperty;
use \Darling\PHPReflectionUtilities\interfaces\utilities\ObjectReflection;
use \Darling\PHPReflectionUtilities\Tests\interfaces\utilities\ReflectionTestTrait;
use \ReflectionObject;

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
     * var_dump($this->objectReflectionTestInstance());
     *
     * // example output:
     * object(Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection)#354 (2) {
     *   ["reflectionClass":"Darling\PHPReflectionUtilities\classes\utilities\Reflection":private]=>
     *   object(ReflectionClass)#353 (1) {
     *     ["name"]=>
     *     string(66) "Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\PrivateMethods"
     *   }
     *   ["object":"Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection":private]=>
     *   object(Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\PrivateMethods)#370 (0) {
     *   }
     * }
     *
     * ```
     *
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/PrivateMethods.php
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
     * var_dump($this->reflectedObject());
     *
     * // example output:
     * object(Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\ClassDExtendsClassCInheirtsFromClassBAndFromClassA)#371 (18) {
     *   ["classABaseClassPrivateProperty":"Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\ClassABaseClass":private]=>
     *   bool(true)
     *   ["classABaseClassProtectedProperty":protected]=>
     *   bool(false)
     *   ["classABaseClassPublicProperty"]=>
     *   bool(true)
     *   ["privatePropertySharedName":"Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\ClassABaseClass":private]=>
     *   bool(true)
     *   ["protectedPropertySharedName":protected]=>
     *   bool(true)
     *   ["publicPropertySharedName"]=>
     *   bool(true)
     *   ["classBExtendsClassAPrivateProperty":"Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\ClassBExtendsClassA":private]=>
     *   bool(true)
     *   ["classBExtendsClassAProtectedProperty":protected]=>
     *   bool(false)
     *   ["classBExtendsClassAPublicProperty"]=>
     *   bool(true)
     *   ["privatePropertySharedName":"Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\ClassBExtendsClassA":private]=>
     *   bool(true)
     *   ["classCExtendsClassBInheirtsFromClassAPrivateProperty":"Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\ClassCExtendsClassBInheirtsFromClassA":private]=>
     *   bool(true)
     *   ["classCExtendsClassBInheirtsFromClassAProtectedProperty":protected]=>
     *   bool(false)
     *   ["classCExtendsClassBInheirtsFromClassAPublicProperty"]=>
     *   bool(true)
     *   ["privatePropertySharedName":"Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\ClassCExtendsClassBInheirtsFromClassA":private]=>
     *   bool(true)
     *   ["classDExtendsClassCInheirtsFromClassBAndFromClassAPrivateProperty":"Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\ClassDExtendsClassCInheirtsFromClassBAndFromClassA":private]=>
     *   bool(true)
     *   ["classDExtendsClassCInheirtsFromClassBAndFromClassAProtectedProperty":protected]=>
     *   bool(false)
     *   ["classDExtendsClassCInheirtsFromClassBAndFromClassAPublicProperty"]=>
     *   NULL
     *   ["privatePropertySharedName":"Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\ClassDExtendsClassCInheirtsFromClassBAndFromClassA":private]=>
     *   bool(true)
     * }
     *
     * ```
     *
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/ClassDExtendsClassCInheirtsFromClassBAndFromClassA.php
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
     * var_dump($this->reflectionTestInstance()->type());
     *
     * // example output:
     *  object(Darling\PHPTextTypes\classes\strings\ClassString)#365 (1) {
     *   ["string":"Darling\PHPTextTypes\classes\strings\Text":private]=>
     *   string(68) "Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\PublicProperties"
     * }
     *
     * var_dump($this->determineReflectedClassesPropertyValues());
     *
     * // example output:
     * array(8) {
     *   ["publicPropertyAcceptsArray"]=>
     *   array(3) {
     *     [0]=>
     *     int(0)
     *     [1]=>
     *     int(1)
     *     [2]=>
     *     int(2)
     *   }
     *   ["publicPropertyAcceptsBool"]=>
     *   bool(true)
     *   ["publicPropertyAcceptsClosureOrNull"]=>
     *   NULL
     *   ["publicPropertyAcceptsFloat"]=>
     *   float(0)
     *   ["publicPropertyAcceptsInt"]=>
     *   int(0)
     *   ["publicPropertyAcceptsObjectOrNull"]=>
     *   NULL
     *   ["publicPropertyAcceptsObject"]=>
     *   NULL
     *   ["publicPropertyAcceptsString"]=>
     *   string(11) "Foo Bar Baz"
     * }
     *
     * ```
     *
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/PublicProperties.php
     *
     */
    protected function determineReflectedClassesPropertyValues(): array
    {
        $reflectionObject = $this->reflectionObject(
            $this->reflectedObject()
        );
        $properties = $reflectionObject->getProperties();
        $propertyValues = array();
        foreach ($properties as $property) {
            $this->addPropertyValueToArray(
                $property,
                $propertyValues
            );
        }
        $this->addParentPropertyValuesToArray(
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
     * var_dump($this->reflectionTestInstance()->type());
     *
     * // example output:
     * object(Darling\PHPTextTypes\classes\strings\ClassString)#351 (1) {
     *   ["string":"Darling\PHPTextTypes\classes\strings\Text":private]=>
     *   string(89) "Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\ClassCExtendsClassBInheirtsFromClassA"
     * }
     *
     * var_dump($propertyValues);
     *
     * // example output:
     * array(20) {
     *   ["classCExtendsClassBInheirtsFromClassAPrivateProperty"]=>
     *   bool(true)
     *   ["classCExtendsClassBInheirtsFromClassAProtectedProperty"]=>
     *   bool(false)
     *   ["classCExtendsClassBInheirtsFromClassAPublicProperty"]=>
     *   bool(true)
     *   ["classCExtendsClassBInheirtsFromClassAPrivateStaticProperty"]=>
     *   bool(true)
     *   ["classCExtendsClassBInheirtsFromClassAProtectedStaticProperty"]=>
     *   bool(false)
     *   ["classCExtendsClassBInheirtsFromClassAPublicStaticProperty"]=>
     *   bool(true)
     *   ["privatePropertySharedName"]=>
     *   bool(true)
     *   ["protectedPropertySharedName"]=>
     *   bool(true)
     *   ["publicPropertySharedName"]=>
     *   bool(true)
     *   ["privateStaticPropertySharedName"]=>
     *   bool(true)
     *   ["protectedStaticPropertySharedName"]=>
     *   bool(true)
     *   ["publicStaticPropertySharedName"]=>
     *   bool(true)
     *   ["classBExtendsClassAProtectedProperty"]=>
     *   bool(false)
     *   ["classBExtendsClassAPublicProperty"]=>
     *   bool(true)
     *   ["classBExtendsClassAProtectedStaticProperty"]=>
     *   bool(false)
     *   ["classBExtendsClassAPublicStaticProperty"]=>
     *   bool(true)
     *   ["classABaseClassProtectedProperty"]=>
     *   bool(false)
     *   ["classABaseClassPublicProperty"]=>
     *   bool(true)
     *   ["classABaseClassProtectedStaticProperty"]=>
     *   bool(false)
     *   ["classABaseClassPublicStaticProperty"]=>
     *   bool(true)
     * }
     *
     * $this->addParentPropertyValuesToArray($propertyValues);
     *
     * var_dump($propertyValues);
     *
     * // example output:
     * array(24) {
     *   ["classCExtendsClassBInheirtsFromClassAPrivateProperty"]=>
     *   bool(true)
     *   ["classCExtendsClassBInheirtsFromClassAProtectedProperty"]=>
     *   bool(false)
     *   ["classCExtendsClassBInheirtsFromClassAPublicProperty"]=>
     *   bool(true)
     *   ["classCExtendsClassBInheirtsFromClassAPrivateStaticProperty"]=>
     *   bool(true)
     *   ["classCExtendsClassBInheirtsFromClassAProtectedStaticProperty"]=>
     *   bool(false)
     *   ["classCExtendsClassBInheirtsFromClassAPublicStaticProperty"]=>
     *   bool(true)
     *   ["privatePropertySharedName"]=>
     *   bool(true)
     *   ["protectedPropertySharedName"]=>
     *   bool(true)
     *   ["publicPropertySharedName"]=>
     *   bool(true)
     *   ["privateStaticPropertySharedName"]=>
     *   bool(true)
     *   ["protectedStaticPropertySharedName"]=>
     *   bool(true)
     *   ["publicStaticPropertySharedName"]=>
     *   bool(true)
     *   ["classBExtendsClassAProtectedProperty"]=>
     *   bool(false)
     *   ["classBExtendsClassAPublicProperty"]=>
     *   bool(true)
     *   ["classBExtendsClassAProtectedStaticProperty"]=>
     *   bool(false)
     *   ["classBExtendsClassAPublicStaticProperty"]=>
     *   bool(true)
     *   ["classABaseClassProtectedProperty"]=>
     *   bool(false)
     *   ["classABaseClassPublicProperty"]=>
     *   bool(true)
     *   ["classABaseClassProtectedStaticProperty"]=>
     *   bool(false)
     *   ["classABaseClassPublicStaticProperty"]=>
     *   bool(true)
     *   ["classBExtendsClassAPrivateProperty"]=>
     *   bool(true)
     *   ["classBExtendsClassAPrivateStaticProperty"]=>
     *   bool(true)
     *   ["classABaseClassPrivateProperty"]=>
     *   bool(true)
     *   ["classABaseClassPrivateStaticProperty"]=>
     *   bool(true)
     * }
     *
     * ```
     *
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/ClassCExtendsClassBInheirtsFromClassA.php
     *
     */
    private function addParentPropertyValuesToArray(
        array &$propertyValues
    ): void
    {
        $reflectionObject = $this->reflectionObject($this->reflectedObject());
        while($parent = $reflectionObject->getParentClass()) {
            foreach($parent->getProperties() as $property) {
                if(!isset($propertyValues[$property->getName()])) {
                    $this->addPropertyValueToArray(
                        $property,
                        $propertyValues
                    );
                }
            }
            $reflectionObject = $parent;
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
     * @param array<string, mixed> $propertyValues The array to add
     *                                             the property's
     *                                             value to.
     *
     * @return void
     *
     * @example
     *
     * ```
     * var_dump($property);
     *
     * // example output:
     * object(ReflectionProperty)#357 (2) {
     *   ["name"]=>
     *   string(22) "reflectedClassProperty"
     *   ["class"]=>
     *   string(66) "Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\ReflectedClass"
     * }
     *
     * var_dump($propertyValues);
     *
     * // example output:
     * array(0) {
     * }
     *
     * $this->addPropertyValueToArray(
     *     $property,
     *     $propertyValues
     * );
     *
     * var_dump($propertyValues);
     *
     * // example output:
     * array(1) {
     *   ["reflectedClassProperty"]=>
     *   string(19) "Foo bar bazz bazzer"
     * }
     *
     * ```
     *
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/ReflectedClass.php
     *
     */
    private function addPropertyValueToArray(
        ReflectionProperty $property,
        array &$propertyValues
    ): void
    {
        if($property->isInitialized($this->reflectedObject())) {
            $property->setAccessible(true);
            $propertyValues[$property->getName()] =
                $property->getValue($this->reflectedObject());
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
     * $this->setObjectReflectionTestInstance(
     *     new \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection(
     *         new \stdClass()
     *     )
     * );
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
     * Return an instance of a ReflectionObject that reflects
     * the reflected object instance.
     *
     * @return ReflectionObject
     *
     */
    public function reflectionObject(object $object): ReflectionObject
    {
        return new ReflectionObject($object);
    }

    /**
     * Return a numerically indexed array of the names of the
     * properties declared by the class or object instance
     * reflected by the Reflection implementation being tested.
     *
     * @param int|null $filter Determine what property names are
     *                         included in the returned array
     *                         based on the following filters:
     *
     *                         ReflectionMethod::IS_FINAL
     *                         ReflectionMethod::IS_PRIVATE
     *                         ReflectionMethod::IS_PROTECTED
     *                         ReflectionMethod::IS_PUBLIC
     *                         ReflectionMethod::IS_STATIC
     *
     *                         The names of the properties declared
     *                         by the reflected class or object
     *                         instance that meet the expectation of
     *                         the given filters will be included in
     *                         the returned array.
     *
     *                         If no filters are specified, then
     *                         the names of all of the properties
     *                         declared by the reflected class or
     *                         object instance will be included
     *                         in the returned array.
     *
     *                         Note: Note that some bitwise
     *                         operations will not work with these
     *                         filters. For instance a bitwise
     *                         NOT (~), will not work as expected.
     *                         For example, it is not possible to
     *                         retrieve all non-static properties
     *                         via a call like:
     *
     *                         ```
     *                         $this->determineReflectedClassesPropertyNames(
     *                             ~ReflectionMethod::IS_STATIC
     *                         );
     *
     *                         ```
     * @return array<int, string>
     *
     * @example
     *
     * ```
     * var_dump(
     *     is_object($this->reflectedClass())
     *     ? $this->reflectedClass()::class
     *     : $this->reflectedClass()
     * );
     *
     * // example output:
     * string(74) "Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\PublicStaticProperties"
     *
     * var_dump(
     *     $this->determineReflectedClassesPropertyNames(
     *         \ReflectionMethod::IS_STATIC
     *     )
     * );
     *
     * array(8) {
     *   [0]=>
     *   string(34) "publicStaticPropertiesPrivateArray"
     *   [1]=>
     *   string(33) "publicStaticPropertiesPrivateBool"
     *   [2]=>
     *   string(36) "publicStaticPropertiesPrivateClosure"
     *   [3]=>
     *   string(34) "publicStaticPropertiesPrivateFloat"
     *   [4]=>
     *   string(32) "publicStaticPropertiesPrivateInt"
     *   [5]=>
     *   string(43) "publicStaticPropertiesPrivateNullableObject"
     *   [6]=>
     *   string(35) "publicStaticPropertiesPrivateObject"
     *   [7]=>
     *   string(35) "publicStaticPropertiesPrivateString"
     * }
     *
     * ```
     *
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/PublicStaticProperties.php
     *
     */
    protected function determineReflectedClassesPropertyNames(
        int|null $filter = null
    ): array
    {
        $reflectionObject = $this->reflectionObject(
            $this->reflectedObject()
        );
        $propertyNames = [];
        foreach(
            $reflectionObject->getProperties($filter)
            as
            $reflectionProperty
        ) {
            array_push(
                $propertyNames,
                $reflectionProperty->getName()
            );
        }
        $this->addParentPropertyNamesToArray(
            $reflectionObject,
            $propertyNames,
            $filter
        );
        $propertyNames = array_unique($propertyNames);
        return $propertyNames;
    }

    /**
     * Test that the propertyValues() method returns an
     * associatively indexed array of the values of the
     * properties defined by the reflected object indexed
     * by property name.
     *
     * @return void
     *
     * @covers Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection::propertyValues()
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
     * @covers Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection::reflectedObject()
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

    /**
     * Test that the reflectionObject method returns an instance of a
     * ReflectionObject that reflects object instance.
     *
     * @return void
     *
     * @covers Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection::reflectionObject()
     *
     */
    public function test_reflectionObject_returns_an_instance_of_a_ReflectionObject_that_reflects_the_object_instance_reflected_by_the_ObjectReflection(): void
    {
        $expectedReflectionClass = $this->reflectionObject($this->reflectedObject);
        $this->assertEquals(
            $expectedReflectionClass,
            $this->objectReflectionTestInstance()->reflectionObject(),
            $this->testFailedMessage(
                $this->objectReflectionTestInstance(),
                'reflectionObject',
                'return an instance of a ReflectionClass that ' .
                'reflects the class or object instance reflected ' .
                'by the reflection'
            ),
        );
    }

}

