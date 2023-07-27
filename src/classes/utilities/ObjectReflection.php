<?php

namespace Darling\PHPReflectionUtilities\classes\utilities;

use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPReflectionUtilities\interfaces\utilities\ObjectReflection as ObjectReflectionInterface;
use \Darling\PHPTextTypes\classes\strings\ClassString;
use \ReflectionClass;
use \ReflectionObject;
use \ReflectionMethod;
use \ReflectionProperty;

class ObjectReflection extends Reflection implements ObjectReflectionInterface
{

    /**
     * Instantiate a new ObjectReflection of the specified object
     * instance.
     *
     * @param object $object The object to reflect.
     *
     * @example
     *
     * ```
     * $reflection =
     *     new \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection(
     *         new \stdclass()
     *     );
     *
     * ```
     *
     */
    public function __construct(
        private object $object
    ) {
        $classString = new ClassString($object);
        parent::__construct($classString);
    }

    public function propertyValues(): array
    {
        $properties = $this->reflectionObject()->getProperties();
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

    public function reflectedObject(): object
    {
        return $this->object;
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
     * var_dump($this->type());
     *
     * // example output:
     * object(Darling\PHPTextTypes\classes\strings\ClassString)#350 (1) {
     *   ["string":"Darling\PHPTextTypes\classes\strings\Text":private]=>
     *   string(71) "Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\ClassBExtendsClassA"
     *
     * }
     *
     * var_dump($propertyValues);
     *
     * // example output:
     * array(16) {
     *   ["classBExtendsClassAPrivateProperty"]=>
     *   bool(true)
     *   ["classBExtendsClassAProtectedProperty"]=>
     *   bool(false)
     *   ["classBExtendsClassAPublicProperty"]=>
     *   bool(true)
     *   ["classBExtendsClassAPrivateStaticProperty"]=>
     *   bool(true)
     *   ["classBExtendsClassAProtectedStaticProperty"]=>
     *   bool(false)
     *   ["classBExtendsClassAPublicStaticProperty"]=>
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
     * array(18) {
     *   ["classBExtendsClassAPrivateProperty"]=>
     *   bool(true)
     *   ["classBExtendsClassAProtectedProperty"]=>
     *   bool(false)
     *   ["classBExtendsClassAPublicProperty"]=>
     *   bool(true)
     *   ["classBExtendsClassAPrivateStaticProperty"]=>
     *   bool(true)
     *   ["classBExtendsClassAProtectedStaticProperty"]=>
     *   bool(false)
     *   ["classBExtendsClassAPublicStaticProperty"]=>
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
     *   ["classABaseClassProtectedProperty"]=>
     *   bool(false)
     *   ["classABaseClassPublicProperty"]=>
     *   bool(true)
     *   ["classABaseClassProtectedStaticProperty"]=>
     *   bool(false)
     *   ["classABaseClassPublicStaticProperty"]=>
     *   bool(true)
     *   ["classABaseClassPrivateProperty"]=>
     *   bool(true)
     *   ["classABaseClassPrivateStaticProperty"]=>
     *   bool(true)
     *
     * ```
     *
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/ClassBExtendsClassA.php
     *
     */
    private function addParentPropertyValuesToArray(
        array &$propertyValues
    ): void
    {
        $reflectionObject = $this->reflectionObject();
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
     * Add the value of a property assigned to the reflected
     * object instance to the specified array.
     *
     * The property's value will be indexed by the property's name.
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
     * object(ReflectionProperty)#364 (2) {
     *   ["name"]=>
     *   string(37) "protectedStaticPropertiesPrivateArray"
     *   ["class"]=>
     *   string(77) "Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\ProtectedStaticProperties"
     * }
     *
     * var_dump($propertyValues);
     *
     * // example output:
     * array(0) {
     * }
     *
     * $this->addPropertyValueToArray($property, $propertyValues);
     *
     * var_dump($propertyValues);
     *
     * // example output:
     * array(1) {
     *   ["protectedStaticPropertiesPrivateArray"]=>
     *   array(3) {
     *     [0]=>
     *     int(0)
     *     [1]=>
     *     int(1)
     *     [2]=>
     *     int(2)
     *   }
     * }
     *
     * ```
     *
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/ProtectedStaticProperties.php
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
        } else {
            $propertyValues[$property->getName()] =
                null;
        }
    }

    public function reflectionObject(): ReflectionObject
    {
        return new ReflectionObject($this->reflectedObject());
    }

    /**
     * Add the names of the properties declared by the parent classes
     * of the object reflected by the specified ReflectionClass
     * instance to the specified array.
     *
     * @param ReflectionClass <object> $reflectionObject
     *                                     An instance of a
     *                                     ReflectionClass that
     *                                     reflects the class or
     *                                     object instance whose
     *                                     parent's property names
     *                                     should be added to the
     *                                     specified array of
     *                                     $propertyNames.
     *
     * @param array<int, string> &$propertyNames The array to add the
     *                                           property names to.
     *
     * @param int|null $filter Determine what property names are
     *                         added to the specified array of
     *                         $propertyNames based on the following
     *                         filters:
     *
     *                         Reflection::IS_FINAL
     *                         Reflection::IS_PRIVATE
     *                         Reflection::IS_PROTECTED
     *                         Reflection::IS_PUBLIC
     *                         Reflection::IS_STATIC
     *
     *                         The names of all of the properties
     *                         declared by the parents of the
     *                         reflected class or object instance
     *                         that meet the expectation of the
     *                         given filters will be added to the
     *                         specified array of $propertyNames.
     *
     *                         If no filters are specified, then
     *                         the names of all of the properties
     *                         declared by the parents of the
     *                         reflected class or object instance
     *                         will be added to the specified array
     *                         of $propertyNames.
     *
     *                         Note: Note that some bitwise
     *                         operations will not work with these
     *                         filters. For instance a bitwise
     *                         NOT (~), will not work as expected.
     *                         For example, it is not possible to
     *                         target all non-static properties
     *                         via a call like:
     *
     *                         ```
     *                         $this->
     *                         determineReflectedClassesPropertyNames(
     *                             ~Reflection::IS_STATIC
     *                         );
     *
     *                         ```
     *
     * @return void
     *
     * @example
     *
     * ```
     * var_dump($this->type());
     *
     * // example output:
     * object(Darling\PHPTextTypes\classes\strings\ClassString)#4 (1) {
     *   ["string":"Darling\PHPTextTypes\classes\strings\Text":private]=>
     *   string(102) "Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\ClassDExtendsClassCInheirtsFromClassBAndFromClassA"
     * }
     *
     * $propertyNames = [];
     *
     * $reflection->addParentPropertyNamesToArray(
     *     $this->reflectionObject(),
     *     $propertyNames,
     *     Reflection::IS_PRIVATE
     * );
     *
     * var_dump($propertyNames);
     *
     * // example output:
     * array(12) {
     *   [0]=>
     *   string(52) "classCExtendsClassBInheirtsFromClassAPrivateProperty"
     *   [1]=>
     *   string(58) "classCExtendsClassBInheirtsFromClassAPrivateStaticProperty"
     *   [2]=>
     *   string(25) "privatePropertySharedName"
     *   [3]=>
     *   string(31) "privateStaticPropertySharedName"
     *   [4]=>
     *   string(34) "classBExtendsClassAPrivateProperty"
     *   [5]=>
     *   string(40) "classBExtendsClassAPrivateStaticProperty"
     *   [6]=>
     *   string(25) "privatePropertySharedName"
     *   [7]=>
     *   string(31) "privateStaticPropertySharedName"
     *   [8]=>
     *   string(30) "classABaseClassPrivateProperty"
     *   [9]=>
     *   string(36) "classABaseClassPrivateStaticProperty"
     *   [10]=>
     *   string(25) "privatePropertySharedName"
     *   [11]=>
     *   string(31) "privateStaticPropertySharedName"
     * }
     *
     * ```
     *
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/ClassDExtendsClassCInheirtsFromClassBAndFromClassA.php
     *
     */
    private function addParentPropertyNamesToArray(
        ReflectionClass $reflectionObject,
        array &$propertyNames,
        $filter = null
    ): void
    {
        while($parent = $reflectionObject->getParentClass()) {
            foreach($parent->getProperties($filter) as $property) {
                array_push($propertyNames, $property->getName());
            }
            $reflectionObject = $parent;
        }
    }

    public function propertyNames(int|null $filter = null): array
    {
        $propertyNames = [];
        foreach(
            $this->reflectionObject()->getProperties($filter)
            as
            $reflectionProperty
        ) {
            array_push($propertyNames, $reflectionProperty->getName());
        }
        $this->addParentPropertyNamesToArray(
            $this->reflectionObject(),
            $propertyNames,
            $filter
        );
        $propertyNames = array_unique($propertyNames);
        return $propertyNames;
    }
}

