<?php

namespace Darling\PHPReflectionUtilities\classes\utilities;

use Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use Darling\PHPReflectionUtilities\interfaces\utilities\ObjectReflection as ObjectReflectionInterface;
use \ReflectionClass;
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
        parent::__construct($this->newReflectionClass($object));
    }

    public function propertyValues(): array
    {
        $properties = $this->reflectionClass()->getProperties();
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
        $reflectionClass = $this->reflectionClass();
        while($parent = $reflectionClass->getParentClass()) {
            foreach($parent->getProperties() as $property) {
                if(!isset($propertyValues[$property->getName()])) {
                    $this->addPropertyValueToArray(
                        $property,
                        $propertyValues
                    );
                }
            }
            $reflectionClass = $parent;
        }
    }

    /**
     * Return an instance of a ReflectionClass to reflect the
     * specified object instance.
     *
     * @param object $object The object instance the ReflectionClass
     *                       instance will reflect.
     *
     * @return ReflectionClass <object>
     *
     * @example
     *
     * ```
     * var_dump($this->newReflectionClass($this->reflectedObject()));
     *
     * object(ReflectionClass)#353 (1) {
     *   ["name"]=>
     *   string(68) "Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\ProtectedMethods"
     * }
     *
     * ```
     *
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/ProtectedMethods.php
     * @see https://www.php.net/manual/en/class.reflectionclass.php
     *
     */
    private function newReflectionClass(object $object): ReflectionClass
    {
        return new ReflectionClass($object);
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
}

