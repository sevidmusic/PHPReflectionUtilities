<?php

namespace tests\interfaces\utilities;

use Darling\PHPReflectionUtilities\interfaces\utilities\Reflection;
use \ReflectionClass;
use \ReflectionMethod;
use \ReflectionNamedType;
use \ReflectionParameter;
use \ReflectionProperty;
use \ReflectionUnionType;

/**
 * The ReflectionTestTrait defines common tests for implementations
 * of the Reflection interface.
 *
 * @see Reflection
 *
 */
trait ReflectionTestTrait
{

    /**
     * @var Reflection $reflection An instance of a Reflection
     *                             implementation to test.
     */
    private Reflection $reflection;

    /**
     * @var class-string|object $reflectedClass The class-string or
     *                                          object instance that
     *                                          is expected to be
     *                                          reflected by the
     *                                          Reflection
     *                                          implementation
     *                                          instance being
     *                                          tested.
     */
    private string|object $reflectedClass;

    /**
     * Return a numerically indexed array of the names of the
     * methods defined by the class or object instance reflected
     * by the Reflection implementation instance being tested.
     *
     * @param int|null $filter Determine what method names are
     *                         included in the returned array
     *                         based on the following filters:
     *
     *                         ReflectionMethod::IS_ABSTRACT
     *                         ReflectionMethod::IS_FINAL
     *                         ReflectionMethod::IS_PRIVATE
     *                         ReflectionMethod::IS_PROTECTED
     *                         ReflectionMethod::IS_PUBLIC
     *                         ReflectionMethod::IS_STATIC
     *
     *                         The names of the methods defined
     *                         by the reflected class or object
     *                         instance that meet the expectation
     *                         of the given filters will be included
     *                         in the returned array.
     *
     *                         If no filters are specified, then
     *                         the names of all of the methods
     *                         defined by the reflected class or
     *                         object instance will be included
     *                         in the returned array.
     *
     *                         Note: Note that some bitwise
     *                         operations will not work with these
     *                         filters. For instance a bitwise
     *                         NOT (~), will not work as expected.
     *                         For example, it is not possible to
     *                         retrieve the names of all of the
     *                         non-static methods via a call like:
     *
     *                         ```
     *                         $this->determineReflectedClassesMethodNames(
     *                             ~ReflectionMethod::IS_STATIC
     *                         );
     *
     *                         ```
     *
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
     * string(45) "tests\dev\mock\classes\ProtectedStaticMethods"
     *
     * $this->determineReflectedClassesMethodNames(
     *     \ReflectionMethod::IS_STATIC
     * );
     *
     * // example output:
     * array(8) {
     *   [0]=>
     *   string(41) "protectedStaticMethodsMethodToReturnArray"
     *   [1]=>
     *   string(40) "protectedStaticMethodsMethodToReturnBool"
     *   [2]=>
     *   string(43) "protectedStaticMethodsMethodToReturnClosure"
     *   [3]=>
     *   string(39) "protectedStaticMethodsMethodToReturnInt"
     *   [4]=>
     *   string(41) "protectedStaticMethodsMethodToReturnFloat"
     *   [5]=>
     *   string(50) "protectedStaticMethodsMethodToReturnNullableObject"
     *   [6]=>
     *   string(42) "protectedStaticMethodsMethodToReturnObject"
     *   [7]=>
     *   string(42) "protectedStaticMethodsMethodToReturnString"
     * }
     *
     * ```
     *
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/ProtectedStaticMethods.php
     *
     */
    protected function determineReflectedClassesMethodNames(
        int|null $filter = null
    ): array
    {
        $reflectionClass = $this->reflectionClass(
            $this->reflectedClass()
        );
        $methodNames = [];
        foreach(
            $reflectionClass->getMethods($filter)
            as
            $reflectionMethod
        ) {
            array_push($methodNames, $reflectionMethod->getName());
        }
        return $methodNames;
    }

    /**
     * Return a numerically indexed array of the names of the
     * parameters expected by the specified method of the class
     * or object instance reflected by the Reflection implementation
     * instance being tested.
     *
     * The parameter names will be ordered according to the order
     * that the parameters are expected by the specified method.
     *
     * @param string $method The name of the method whose parameter
     *                       names should be included in the
     *                       returned array.
     *
     * @return array<int, string>
     *
     * @example
     *
     * ```
     * var_dump(
     *     is_object($this->reflectedClass())
     *     ? $this->reflectedClass()::class :
     *     $this->reflectedClass()
     * );
     *
     * // example output:
     * string(36) "tests\dev\mock\classes\PublicMethods"
     *
     * var_dump(
     *     $this->determineReflectedClassesMethodParameterNames(
     *         'publicMethodToReturnFloat'
     *     )
     * );
     *
     * // example output:
     * array(1) {
     *   [0]=>
     *   string(21) "parameterAcceptsFloat"
     * }
     *
     * ```
     *
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/PublicMethods.php
     *
     */
    protected function determineReflectedClassesMethodParameterNames(
        string $method
    ): array
    {
        if(empty($method)) {
            return [];
        }
        $reflectionClass = $this->reflectionClass(
            $this->reflectedClass()
        );
        $parameterNames = [];
        foreach(
            $this->reflectionMethod($method)->getParameters()
            as
            $reflectionParameter
        ) {
            array_push(
                $parameterNames,
                $reflectionParameter->getName()
            );
        }
        return $parameterNames;
    }

    /**
     * Returns an associatively indexed array of numerically
     * indexed arrays of strings indicating the types accepted
     * by the parameters expected by the specified method of
     * the class or object instance reflected by the Reflection
     * implementation being tested.
     *
     * The arrays of strings indicating the types accepted by each
     * parameter will be indexed by the name of the parameter they
     * are associated with.
     *
     * @param string $method The name of the method.
     *
     * @return array<string, array<int, string>>
     *
     * @example
     *
     * ```
     * var_dump(
     *     is_object($this->reflectedClass())
     *     ? $this->reflectedClass()::class :
     *     $this->reflectedClass()
     * );
     *
     * // example output
     * string(42) "tests\dev\mock\classes\PublicStaticMethods"
     *
     * var_dump(
     *     $this->determineReflectedClassesMethodParameterTypes(
     *         'publicStaticMethodsMethodToReturnArray'
     *     )
     * );
     *
     * // example output:
     * array(2) {
     *   ["parameterAcceptsArray"]=>
     *   array(1) {
     *     [0]=>
     *     string(5) "array"
     *   }
     *   ["parameterAcceptsBoolOrNull"]=>
     *   array(2) {
     *     [0]=>
     *     string(4) "bool"
     *     [1]=>
     *     string(4) "null"
     *   }
     * }
     *
     * ```
     *
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/PublicStaticMethods.php
     *
     */
    protected function determineReflectedClassesMethodParameterTypes(
        string $method
    ): array
    {
        if(empty($method)) { return []; }
        $reflectionClass = $this->reflectionClass(
            $this->reflectedClass()
        );
        $parameterTypes = [];
        foreach(
            $this->reflectionMethod($method)->getParameters()
            as
            $reflectionParameter
        ) {
            $type = $reflectionParameter->getType();
            if(!$type instanceof \ReflectionType) { continue; }
            if($type instanceof ReflectionUnionType) {
                $this->addUnionTypesToArray(
                    $reflectionParameter,
                    $parameterTypes,
                    $type
                );
                continue;
            }
            if($type instanceof ReflectionNamedType) {
                $this->addNamedTypeToArray(
                    $reflectionParameter,
                    $parameterTypes,
                    $type
                );
            }
        }
        return $parameterTypes;
    }

    /**
     * Add an array of strings indicating the types reflected by
     * the specified $reflectionUnionType to the specified array of
     * $types.
     *
     * If the $reflectionUnionType is nullable, then the string
     * "null" will be included in the array of strings.
     *
     * The array of strings will be indexed in the array of $types
     * by the specified $parameterOrProperty's name.
     *
     * @param ReflectionParameter|ReflectionProperty $parameterOrProperty
     *                                           An instance of a
     *                                           ReflectionParameter
     *                                           or a
     *                                           ReflectionProperty
     *                                           that reflects the
     *                                           parameter or
     *                                           property whose name
     *                                           will be used to
     *                                           index the array of
     *                                           strings indicating
     *                                           the types reflected
     *                                           by the specified
     *                                           $reflectionUnionType.
     *
     * @param array<string, array<int, string>> &$types
     *                                             The array of $types
     *                                             to add the array of
     *                                             strings indicating
     *                                             the types reflected
     *                                             by the specified
     *                                             ReflectionUnionType
     *                                             to.
     *
     * @param ReflectionUnionType $reflectionUnionType
     *                                            An instance of a
     *                                            ReflectionUnionType
     *                                            that reflects the
     *                                            types that are to
     *                                            be represented in
     *                                            the array that will
     *                                            be added to the
     *                                            specified array of
     *                                            $types.
     *
     * @return void
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
     * string(38) "tests\dev\mock\classes\ClassABaseClass"
     *
     * var_dump($parameterOrProperty);
     *
     * // example output:
     * object(ReflectionProperty)#355 (2) {
     *   ["name"]=>
     *   string(29) "classABaseClassPublicProperty"
     *   ["class"]=>
     *   string(38) "tests\dev\mock\classes\ClassABaseClass"
     * }
     *
     * var_dump($types);
     *
     * // example output:
     * array(0) {
     * }
     *
     * var_dump($reflectionUnionType);
     *
     * // example output:
     * object(ReflectionUnionType)#360 (0) {
     * }
     *
     * $this->addUnionTypesToArray(
     *     $parameterOrProperty,
     *     $types,
     *     $reflectionUnionType
     * );
     *
     * var_dump($types);
     *
     * // example output:
     * array(1) {
     *   ["classABaseClassPublicProperty"]=>
     *   array(2) {
     *     [0]=>
     *     string(3) "int"
     *     [1]=>
     *     string(4) "bool"
     *   }
     * }
     *
     * ```
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/ClassABaseClass.php
     *
     */
    private function addUnionTypesToArray(
        ReflectionProperty
        |ReflectionParameter $parameterOrProperty,
        array &$types,
        ReflectionUnionType $reflectionUnionType
    ): void
    {
        $reflectionUnionTypes = $reflectionUnionType->getTypes();
        foreach($reflectionUnionTypes as $unionType) {
            $types[$parameterOrProperty->getName()][]
                = $unionType->getName();
            $types[$parameterOrProperty->getName()] =
                array_unique(
                    $types[$parameterOrProperty->getName()]
                );
        }
        if(
            !in_array(
                'null',
                $types[$parameterOrProperty->getName()]
            )
            &&
            $reflectionUnionType->allowsNull()
        ) {
            $types[$parameterOrProperty->getName()][]
                = 'null';
        }
    }

    /**
     * Add an array of strings indicating the types reflected by the
     * specified $reflectionNamedType to the specified array of
     * $types.
     *
     * If the $reflectionNamedType is nullable, then the string
     * "null" will also be included in the array of strings.
     *
     * The array of strings will be indexed in the array of $types
     * by the specified $parameterOrProperty's name.
     *
     * @param ReflectionParameter|ReflectionProperty $parameterOrProperty
     *                                           An instance of a
     *                                           ReflectionParameter
     *                                           or a
     *                                           ReflectionProperty
     *                                           that reflects the
     *                                           parameter or
     *                                           property whose name
     *                                           will be used to
     *                                           index the array of
     *                                           strings indicating
     *                                           the types reflected
     *                                           by the specified
     *                                           $reflectionNamedType.
     *
     * @param array<string, array<int, string>> &$types
     *                                             The array of $types
     *                                             to add the array of
     *                                             strings indicating
     *                                             the types reflected
     *                                             by the specified
     *                                             ReflectionNamedType
     *                                             to.
     *
     * @param ReflectionNamedType $reflectionNamedType
     *                                            An instance of a
     *                                            ReflectionNamedType
     *                                            that reflects the
     *                                            types that are to
     *                                            be indicated by
     *                                            strings in the
     *                                            array that will be
     *                                            added to the
     *                                            specified array of
     *                                            $types.
     *
     * @return void
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
     * string(36) "tests\dev\mock\classes\PublicMethods"
     *
     * var_dump($parameterOrProperty);
     *
     * // example output:
     * object(ReflectionParameter)#358 (1) {
     *   ["name"]=>
     *   string(22) "parameterAcceptsString"
     * }
     *
     * var_dump($types);
     *
     * // example output:
     * array(0) {
     * }
     *
     * var_dump($reflectionNamedType);
     *
     * // example output:
     * object(ReflectionNamedType)#364 (0) {
     * }
     *
     * $this->addNamedTypeToArray(
     *     $parameterOrProperty,
     *     $types,
     *     $reflectionNamedType
     * ;
     *
     * var_dump($types);
     *
     * // example output:
     * array(1) {
     *   ["parameterAcceptsString"]=>
     *   array(1) {
     *     [0]=>
     *     string(6) "string"
     *   }
     * }
     *
     * ```
     *
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/PublicMethods.php
     *
     */
    private function addNamedTypeToArray(
        ReflectionProperty
        |ReflectionParameter $parameterOrProperty,
        array &$types,
        ReflectionNamedType $reflectionNamedType
    ): void
    {
        $types[$parameterOrProperty->getName()] =
            [$reflectionNamedType->getName()];
        if($reflectionNamedType->allowsNull()) {
            $types[$parameterOrProperty->getName()][] =
                'null';
        }
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
     * string(45) "tests\dev\mock\classes\PublicStaticProperties"
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
        $reflectionClass = $this->reflectionClass(
            $this->reflectedClass()
        );
        $propertyNames = [];
        foreach(
            $reflectionClass->getProperties($filter)
            as
            $reflectionProperty
        ) {
            array_push(
                $propertyNames,
                $reflectionProperty->getName()
            );
        }
        $this->addParentPropertyNamesToArray(
            $reflectionClass,
            $propertyNames,
            $filter
        );
        $propertyNames = array_unique($propertyNames);
        return $propertyNames;
    }

    /**
     * Add the names of the properties declared by the parent classes
     * of the object reflected by the specified ReflectionClass
     * instance to the specified array.
     *
     * @param ReflectionClass <object> $reflectionClass
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
     *                         ReflectionMethod::IS_FINAL
     *                         ReflectionMethod::IS_PRIVATE
     *                         ReflectionMethod::IS_PROTECTED
     *                         ReflectionMethod::IS_PUBLIC
     *                         ReflectionMethod::IS_STATIC
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
     *                         addParentPropertyNamesToArray(
     *                             $this->reflectedClass()::class,
     *                             $propertyNames,
     *                             Reflection::IS_PRIVATE
     *                         );
     *
     *                         ```
     *
     * @return void
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
     * string(60) "tests\dev\mock\classes\ClassCExtendsClassBInheirtsFromClassA"
     *
     * var_dump($reflectionClass);
     *
     * // example output:
     * object(ReflectionClass)#344 (1) {
     *   ["name"]=>
     *   string(60) "tests\dev\mock\classes\ClassCExtendsClassBInheirtsFromClassA"
     * }
     *
     * var_dump($propertyNames);
     *
     * // example output:
     * array(4) {
     *   [0]=>
     *   string(52) "classCExtendsClassBInheirtsFromClassAPrivateProperty"
     *   [1]=>
     *   string(58) "classCExtendsClassBInheirtsFromClassAPrivateStaticProperty"
     *   [2]=>
     *   string(25) "privatePropertySharedName"
     *   [3]=>
     *   string(31) "privateStaticPropertySharedName"
     * }
     *
     * var_dump($filter);
     *
     * // example output:
     * int(4) // === \ReflectionMethod::IS_PRIVATE
     *
     * $this->addParentPropertyNamesToArray(
     *     $reflectionClass,
     *     $propertyNames,
     *     $filter
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
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/ClassCExtendsClassBInheirtsFromClassA.php
     *
     */
    private function addParentPropertyNamesToArray(
        ReflectionClass $reflectionClass,
        array &$propertyNames,
        $filter = null
    ): void
    {
        while($parent = $reflectionClass->getParentClass()) {
            foreach($parent->getProperties($filter) as $property) {
                array_push($propertyNames, $property->getName());
            }
            $reflectionClass = $parent;
        }

    }

    /**
     * Return an associatively indexed array of numerically
     * indexed arrays of strings indicating the types accepted
     * by the properties declared by the class or object instance
     * reflected by the Reflection implementation instance being
     * tested.
     *
     * The arrays of strings indicating the types accepted by each
     * property will be indexed by the name of the property they
     * are associated with.
     *
     * @param int|null $filter Determine which properties should
     *                         have an array of strings indicating
     *                         their accepted types included in
     *                         the returned array based on the
     *                         following filters:
     *
     *                         ReflectionMethod::IS_FINAL
     *                         ReflectionMethod::IS_PRIVATE
     *                         ReflectionMethod::IS_PROTECTED
     *                         ReflectionMethod::IS_PUBLIC
     *                         ReflectionMethod::IS_STATIC
     *
     *                         Each property declared by the reflected
     *                         class or object instance that meets
     *                         the expectation of the specified
     *                         filters will have an array of strings
     *                         indicating the types accepted by the
     *                         property included in the returned
     *                         array.
     *
     *                         If no filters are specified, then all
     *                         properties declared by the reflected
     *                         class or object instance will have an
     *                         array of strings indicating the types
     *                         accepted by the property included in
     *                         the returned array.
     *
     *                         Note: Note that some bitwise
     *                         operations will not work with these
     *                         filters. For instance a bitwise
     *                         NOT (~), will not work as expected.
     *                         For example, it is not possible to
     *                         retrieve the types of all non-static
     *                         properties via a call like:
     *
     *                         ```
     *                         $this->
     *                         determineReflectedClassesPropertyTypes(
     *                             ~ReflectionMethod::IS_STATIC
     *                         );
     *
     *                         ```
     *
     * @return array<string, array<int, string>>
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
     * string(46) "tests\dev\mock\classes\PrivateStaticProperties"
     *
     * var_dump(
     *     $this->addParentPropertyNamesToArray(
     *         \ReflectionMethod::IS_PRIVATE
     *     )
     * );
     *
     * // example output:
     * array(8) {
     *   ["privateStaticPropertiesPrivateArray"]=>
     *   array(1) {
     *     [0]=>
     *     string(5) "array"
     *   }
     *   ["privateStaticPropertiesPrivateBool"]=>
     *   array(1) {
     *     [0]=>
     *     string(4) "bool"
     *   }
     *   ["privateStaticPropertiesPrivateClosure"]=>
     *   array(2) {
     *     [0]=>
     *     string(7) "Closure"
     *     [1]=>
     *     string(4) "null"
     *   }
     *   ["privateStaticPropertiesPrivateFloat"]=>
     *   array(1) {
     *     [0]=>
     *     string(5) "float"
     *   }
     *   ["privateStaticPropertiesPrivateInt"]=>
     *   array(1) {
     *     [0]=>
     *     string(3) "int"
     *   }
     *   ["privateStaticPropertiesPrivateNullableObject"]=>
     *   array(2) {
     *     [0]=>
     *     string(6) "object"
     *     [1]=>
     *     string(4) "null"
     *   }
     *   ["privateStaticPropertiesPrivateObject"]=>
     *   array(1) {
     *     [0]=>
     *     string(6) "object"
     *   }
     *   ["privateStaticPropertiesPrivateString"]=>
     *   array(1) {
     *     [0]=>
     *     string(6) "string"
     *   }
     * }
     *
     * ```
     *
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/PrivateStaticProperties.php
     */
    protected function determineReflectedClassesPropertyTypes(int $filter = null): array
    {
        $reflectionClass = $this->reflectionClass(
            $this->reflectedClass()
        );
        $propertyTypes = [];
        foreach(
            $reflectionClass->getProperties($filter)
            as
            $reflectionProperty
        ) {
            $type = $reflectionProperty->getType();
            if(!$type instanceof \ReflectionType) { continue; }
            if($type instanceof ReflectionUnionType) {
                $this->addUnionTypesToArray(
                    $reflectionProperty,
                    $propertyTypes,
                    $type
                );
                continue;
            }
            if($type instanceof ReflectionNamedType) {
                $this->addNamedTypeToArray(
                    $reflectionProperty,
                    $propertyTypes,
                    $type
                );
            }
        }
        $this->addParentPropertyTypesToArray(
            $reflectionClass,
            $propertyTypes,
            $filter
        );
        return $propertyTypes;
    }

    /**
     * For each property declared by the parents of the class or
     * object instance reflected by the Reflection implementation
     * instance being tested add a numerically indexed array of
     * strings that indicate the types accepted by the property
     * to the specified array of $propertyTypes.
     *
     * @param ReflectionClass <object> $reflectionClass
     *                                     An instance of a
     *                                     ReflectionClass that
     *                                     reflects the class or
     *                                     object instance that
     *                                     is to have arrays of
     *                                     strings indicating the
     *                                     types accepted by each
     *                                     property declared by
     *                                     it's parents added to
     *                                     the specified array of
     *                                     $propertyTypes.
     *
     * @param array<string, array<int, string>> &$propertyTypes The
     *                                                          array
     *                                                          to add
     *                                                          the
     *                                                          arrays
     *                                                          to.
     *
     * @param int|null $filter Determine what properties have an
     *                         array of strings indicating their
     *                         accepted types added to the specified
     *                         array of $propertyTypes based on the
     *                         following filters:
     *
     *                         ReflectionMethod::IS_FINAL
     *                         ReflectionMethod::IS_PRIVATE
     *                         ReflectionMethod::IS_PROTECTED
     *                         ReflectionMethod::IS_PUBLIC
     *                         ReflectionMethod::IS_STATIC
     *
     *                         An array of strings indicating a
     *                         property's accepted types will be
     *                         added to the specified array of
     *                         $propertyTypes for each property
     *                         declared by the parents of the
     *                         reflected class or object instance
     *                         that meets the expectation of the
     *                         given filters.
     *
     *                         If no filters are specified, then
     *                         an array of strings indicating a
     *                         property's accepted types will be
     *                         added to the specified array of
     *                         $propertyTypes for each property
     *                         declared by the parents of the
     *                         reflected class or object instance.
     *
     *                         Note: Note that some bitwise
     *                         operations will not work with
     *                         these filters. For instance a
     *                         bitwise NOT (~), will not work
     *                         as expected. For example, it is
     *                         not possible to target all non-static
     *                         properties via a call like:
     *
     *                         ```
     *
     *                         $propertyNames = [];
     *                         $this->addParentPropertyTypesToArray(
     *                             $this->reflectionClass(),
     *                             $propertyTypes,
     *                             ~ReflectionMethod::IS_STATIC
     *                         );
     *
     *                         ```
     *
     * @return void
     *
     * @example
     *
     * ```
     * var_dump($reflectionClass);
     *
     * // example output:
     * object(ReflectionClass)#356 (1) {
     *   ["name"]=>
     *   string(41) "tests\dev\mock\classes\ReflectedBaseClass"
     * }
     *
     * var_dump($propertyTypes);
     *
     * array(19) {
     *   ["reflectedBaseFoo"]=>
     *   array(1) {
     *     [0]=>
     *     string(6) "string"
     *   }
     *   ["privateNullableProperty"]=>
     *   array(2) {
     *     [0]=>
     *     string(3) "int"
     *     [1]=>
     *     string(4) "null"
     *   }
     *   ["privateClosureProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(7) "Closure"
     *   }
     *   ["privateArrayProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(5) "array"
     *   }
     *   ["privateBoolProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(4) "bool"
     *   }
     *   ["privateFloatProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(5) "float"
     *   }
     *   ["privateIntProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(3) "int"
     *   }
     *   ["privateUnionTypeProperty"]=>
     *   array(3) {
     *     [0]=>
     *     string(6) "string"
     *     [1]=>
     *     string(3) "int"
     *     [2]=>
     *     string(4) "bool"
     *   }
     *   ["privateMixedProperty"]=>
     *   array(2) {
     *     [0]=>
     *     string(5) "mixed"
     *     [1]=>
     *     string(4) "null"
     *   }
     *   ["privateObjectProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(6) "object"
     *   }
     *   ["privateStaticNullableProperty"]=>
     *   array(2) {
     *     [0]=>
     *     string(3) "int"
     *     [1]=>
     *     string(4) "null"
     *   }
     *   ["privateStaticClosureProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(7) "Closure"
     *   }
     *   ["privateStaticArrayProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(5) "array"
     *   }
     *   ["privateStaticBoolProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(4) "bool"
     *   }
     *   ["privateStaticFloatProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(5) "float"
     *   }
     *   ["privateStaticIntProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(3) "int"
     *   }
     *   ["privateStaticUnionTypeProperty"]=>
     *   array(3) {
     *     [0]=>
     *     string(6) "string"
     *     [1]=>
     *     string(3) "int"
     *     [2]=>
     *     string(4) "bool"
     *   }
     *   ["privateStaticMixedProperty"]=>
     *   array(2) {
     *     [0]=>
     *     string(5) "mixed"
     *     [1]=>
     *     string(4) "null"
     *   }
     *   ["privateStaticObjectProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(6) "object"
     *   }
     * }
     *
     * $this->addParentPropertyTypesToArray(
     *     $reflectionClass,
     *     $propertyTypes,
     *     \ReflectionMethod::IS_PRIVATE
     * );
     *
     * var_dump($propertyTypes);
     *
     * // example output:
     * array(37) {
     *   ["reflectedBaseFoo"]=>
     *   array(1) {
     *     [0]=>
     *     string(6) "string"
     *   }
     *   ["privateNullableProperty"]=>
     *   array(2) {
     *     [0]=>
     *     string(3) "int"
     *     [1]=>
     *     string(4) "null"
     *   }
     *   ["privateClosureProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(7) "Closure"
     *   }
     *   ["privateArrayProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(5) "array"
     *   }
     *   ["privateBoolProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(4) "bool"
     *   }
     *   ["privateFloatProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(5) "float"
     *   }
     *   ["privateIntProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(3) "int"
     *   }
     *   ["privateUnionTypeProperty"]=>
     *   array(3) {
     *     [0]=>
     *     string(6) "string"
     *     [1]=>
     *     string(3) "int"
     *     [2]=>
     *     string(4) "bool"
     *   }
     *   ["privateMixedProperty"]=>
     *   array(2) {
     *     [0]=>
     *     string(5) "mixed"
     *     [1]=>
     *     string(4) "null"
     *   }
     *   ["privateObjectProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(6) "object"
     *   }
     *   ["privateStaticNullableProperty"]=>
     *   array(2) {
     *     [0]=>
     *     string(3) "int"
     *     [1]=>
     *     string(4) "null"
     *   }
     *   ["privateStaticClosureProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(7) "Closure"
     *   }
     *   ["privateStaticArrayProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(5) "array"
     *   }
     *   ["privateStaticBoolProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(4) "bool"
     *   }
     *   ["privateStaticFloatProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(5) "float"
     *   }
     *   ["privateStaticIntProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(3) "int"
     *   }
     *   ["privateStaticUnionTypeProperty"]=>
     *   array(3) {
     *     [0]=>
     *     string(6) "string"
     *     [1]=>
     *     string(3) "int"
     *     [2]=>
     *     string(4) "bool"
     *   }
     *   ["privateStaticMixedProperty"]=>
     *   array(2) {
     *     [0]=>
     *     string(5) "mixed"
     *     [1]=>
     *     string(4) "null"
     *   }
     *   ["privateStaticObjectProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(6) "object"
     *   }
     *   ["parentPrivateNullableProperty"]=>
     *   array(2) {
     *     [0]=>
     *     string(3) "int"
     *     [1]=>
     *     string(4) "null"
     *   }
     *   ["parentPrivateClosureProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(7) "Closure"
     *   }
     *   ["parentPrivateArrayProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(5) "array"
     *   }
     *   ["parentPrivateBoolProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(4) "bool"
     *   }
     *   ["parentPrivateFloatProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(5) "float"
     *   }
     *   ["parentPrivateIntProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(3) "int"
     *   }
     *   ["parentPrivateUnionTypeProperty"]=>
     *   array(3) {
     *     [0]=>
     *     string(6) "string"
     *     [1]=>
     *     string(3) "int"
     *     [2]=>
     *     string(4) "bool"
     *   }
     *   ["parentPrivateMixedProperty"]=>
     *   array(2) {
     *     [0]=>
     *     string(5) "mixed"
     *     [1]=>
     *     string(4) "null"
     *   }
     *   ["parentPrivateObjectProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(6) "object"
     *   }
     *   ["parentPrivateStaticNullableProperty"]=>
     *   array(2) {
     *     [0]=>
     *     string(3) "int"
     *     [1]=>
     *     string(4) "null"
     *   }
     *   ["parentPrivateStaticClosureProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(7) "Closure"
     *   }
     *   ["parentPrivateStaticArrayProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(5) "array"
     *   }
     *   ["parentPrivateStaticBoolProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(4) "bool"
     *   }
     *   ["parentPrivateStaticFloatProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(5) "float"
     *   }
     *   ["parentPrivateStaticIntProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(3) "int"
     *   }
     *   ["parentPrivateStaticUnionTypeProperty"]=>
     *   array(3) {
     *     [0]=>
     *     string(6) "string"
     *     [1]=>
     *     string(3) "int"
     *     [2]=>
     *     string(4) "bool"
     *   }
     *   ["parentPrivateStaticMixedProperty"]=>
     *   array(2) {
     *     [0]=>
     *     string(5) "mixed"
     *     [1]=>
     *     string(4) "null"
     *   }
     *   ["parentPrivateStaticObjectProperty"]=>
     *   array(1) {
     *     [0]=>
     *     string(6) "object"
     *   }
     * }
     *
     * ```
     *
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/ReflectedBaseClass.php
     *
     */
    private function addParentPropertyTypesToArray(
        ReflectionClass $reflectionClass,
        array &$propertyTypes,
        $filter = null
    ): void
    {
        while($parent = $reflectionClass->getParentClass()) {
            foreach($parent->getProperties($filter) as $property) {
                $type = $property->getType();
                if(!$type instanceof \ReflectionType) { continue; }
                if($type instanceof ReflectionUnionType) {
                    $this->addUnionTypesToArray(
                        $property,
                        $propertyTypes,
                        $type
                    );
                    continue;
                }
                if($type instanceof ReflectionNamedType) {
                    $this->addNamedTypeToArray(
                        $property,
                        $propertyTypes,
                        $type
                    );
                }
            }
            $reflectionClass = $parent;
        }
    }

    /**
     * Return an instance of a ReflectionMethod for the specified
     * method of the class or object instance reflected by the
     * Reflection implementation being tested.
     *
     * @param string $method The name of the method to be reflected
     *                       by the returned ReflectionMethod
     *                       instance.
     *
     * @return ReflectionMethod
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
     * string(42) "tests\dev\mock\classes\ClassBExtendsClassA"
     *
     * var_dump(
     *     $this->reflectionMethod('classBExtendsClassAPrivateMethod')
     * );
     *
     * // example output:
     * object(ReflectionMethod)#344 (2) {
     *   ["name"]=>
     *   string(32) "classBExtendsClassAPrivateMethod"
     *   ["class"]=>
     *   string(42) "tests\dev\mock\classes\ClassBExtendsClassA"
     *
     * ```
     *
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/ClassBExtendsClassA.php
     *
     */
    private function reflectionMethod(
        string $method
    ): ReflectionMethod
    {
        return new ReflectionMethod(
            $this->reflectedClass(),
            $method
        );
    }

    /**
     * Return the class-string or object instance to be reflected by
     * the Reflection implementation instance being tested.
     *
     * @return class-string|object
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
     * string(42) "tests\dev\mock\classes\ClassBExtendsClassA"
     *
     * ```
     *
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/ClassBExtendsClassA.php
     *
     */
    public function reflectedClass(): string|object
    {
        return $this->reflectedClass;
    }

    /**
     * Return the Reflection implementation instance to test.
     *
     * @return Reflection
     *
     * @example
     *
     * ```
     * var_dump($this->reflectionTestInstance());
     *
     * object(Darling\PHPReflectionUtilities\classes\utilities\Reflection)#345 (1) {
     *   ["reflectionClass":"Darling\PHPReflectionUtilities\classes\utilities\Reflection":private]=>
     *   object(ReflectionClass)#344 (1) {
     *     ["name"]=>
     *     string(45) "tests\dev\mock\classes\PublicStaticProperties"
     *   }
     * }
     *
     * ```
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/PublicStaticProperties.php
     *
     */
    protected function reflectionTestInstance(): Reflection
    {
        return $this->reflection;
    }

    /**
     * Set the Reflection implementation instance to test.
     *
     * @param Reflection $reflectionTestInstance An instance of an
     *                                           implementation of
     *                                           the Reflection
     *                                           interface to test.
     *
     * @return void
     *
     * @example
     *
     * ```
     * $this->setReflectionTestInstance(
     *     new \Darling\PHPReflectionUtilities\interfaces\utilities\Reflection(
     *         new \ReflectionClass(
     *             \Darling\PHPReflectionUtilities\interfaces\utilities\Reflection::class
     *         )
     *     );
     * );
     *
     * ```
     *
     * @see https://www.php.net/manual/en/class.reflectionclass.php
     *
     */
    protected function setReflectionTestInstance(
        Reflection $reflectionTestInstance
    ): void
    {
        $this->reflection = $reflectionTestInstance;
    }

    /**
     * Set up an instance of a Reflection to test using a random
     * class string or object instance.
     *
     * This method must set the class or object instance that
     * is expected to be reflected by the Reflection implementation
     * instance to test via the setClassToBeReflected() method.
     *
     * This method must also set the Reflection implementation
     * instance to test via the setReflectionTestInstance()
     * method.
     *
     * This method may perform any additional set up required by
     * the Reflection implementation being tested.
     *
     * @return void
     *
     * @example
     *
     * ```
     * protected function setUp(): void
     * {
     *     $class = $this->randomClassStringOrObjectInstance();
     *     $this->setClassToBeReflected($class);
     *     $this->setReflectionTestInstance(
     *         new Reflection(
     *             $this->reflectionClass($class)
     *         )
     *     );
     * }
     *
     * ```
     *
     */
    abstract protected function setUp(): void;

    /**
     * Set the class-string or object instance that is expected to
     * be reflected by the Reflection implementation instance being
     * tested.
     *
     * @param class-string|object $class The class-string or object
     *                                   instance to be reflected.
     *
     * @example
     *
     * ```
     * $this->setClassToBeReflected(
     *     $this->randomClassStringOrObjectInstance()
     * );
     *
     * ```
     *
     */
    abstract protected function setClassToBeReflected(
        string|object $class
    ): void;

    /**
     * Return an instance of a ReflectionClass instantiated
     * with the specified class string or object instance.
     *
     * @param class-string|object $class The class string or object
     *                                   instance the ReflectionClass
     *                                   instance will reflect.
     *
     * @return ReflectionClass <object>
     *
     * @example
     *
     * ```
     * var_dump($class);
     * object(tests\dev\mock\classes\ProtectedMethods)#366 (0) {
     * }
     *
     * var_dump($this->reflectionClass($class));
     *
     * // example output:
     * object(ReflectionClass)#356 (1) {
     *   ["name"]=>
     *   string(39) "tests\dev\mock\classes\ProtectedMethods"
     * }
     *
     * ```
     *
     * @see https://www.php.net/manual/en/class.reflectionclass.php
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/ProtectedMethods.php
     *
     */
    protected function reflectionClass(
        string|object $class
    ): ReflectionClass
    {
        return new ReflectionClass($class);
    }

    /**
     * Return the name of a randomly chosen method defined by
     * the reflected class or object instance.
     *
     * If the reflected class or object instance does not define
     * any methods, then an empty string will be returned.
     *
     * @return string
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
     * string(46) "tests\dev\mock\classes\PrivateStaticProperties"
     *
     * var_dump($this->randomMethodName());
     *
     * // example output:
     * string(38) "getPrivateStaticPropertiesPrivateArray"
     *
     * ```
     *
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/
     * @see https://github.com/sevidmusic/PHPUnitTestUtilities/blob/main/tests/dev/mock/classes/PrivateStaticProperties.php
     *
     */
    protected function randomMethodName(): string
    {
        $methodNames = $this->determineReflectedClassesMethodNames();
        return (
            empty($methodNames)
            ? ''
            : $methodNames[array_rand($methodNames)]
        );
    }

    /**
     * Test that the type() method returns the type of the
     * reflected class.
     *
     * @return void
     *
     */
    public function test_type_returns_type_of_reflected_class(): void
    {
        $this->assertEquals(
            (
                is_object($this->reflectedClass())
                ? $this->reflectedClass()::class
                : $this->reflectedClass()
            ),
            $this->reflectionTestInstance()->type(),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'type',
                'return the type of the reflected class'
            ),
        );
    }

    /**
     * Test that the methodNames() method returns a numerically
     * indexed array of the names of all the methods defined by
     * the reflected class if no filter is specified.
     *
     * @return void
     *
     */
    public function test_methodNames_returns_the_names_of_all_the_methods_defined_by_the_reflected_class_if_no_filter_is_specified(): void
    {
        $this->assertEquals(
            $this->determineReflectedClassesMethodNames(),
            $this->reflectionTestInstance()->methodNames(),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'methodNames',
                'return an array of all the names of the methods ' .
                'defined by the reflected class if no filter is ' .
                'specified'
            )
        );
    }

    /**
     * Test that the methodNames() method returns a numerically
     * indexed array of the names of the abstract methods defined
     * by the reflected class if the Reflection::IS_ABSTRACT
     * filter is specified.
     *
     * @return void
     *
     */
    public function test_methodNames_returns_the_names_of_the_abstract_methods_defined_by_the_reflected_class_if_the_ReflectionIS_ABSTRACT_filter_is_specified(): void
    {
        $this->assertEquals(
            /**
             * ReflectionMethod::IS_ABSTRACT is used intentionally to
             * test that the effect of passing Reflection::IS_ABSTRACT
             * to the methodNames() method is the same as passing
             * ReflectionMethod::IS_ABSTRACT to the methodNames()
             * method.
             */
            $this->determineReflectedClassesMethodNames(
                ReflectionMethod::IS_ABSTRACT
            ),
            $this->reflectionTestInstance()->methodNames(
                Reflection::IS_ABSTRACT
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'methodNames',
                'return an array of the names of the abstract ' .
                'methods defined by the reflected class if the' .
                'ReflectionClass::IS_ABSTRACT filter is specified'
            )
        );
    }

    /**
     * Test that the methodNames() method returns a numerically
     * indexed array of the names of the final methods defined
     * by the reflected class if the Reflection::IS_FINAL
     * filter is specified.
     *
     * @return void
     *
     */
    public function test_methodNames_returns_the_names_of_the_final_methods_defined_by_the_reflected_class_if_the_ReflectionIS_FINAL_filter_is_specified(): void
    {
        $this->assertEquals(
            /**
             * ReflectionMethod::IS_FINAL is used intentionally to
             * test that the effect of passing Reflection::IS_FINAL
             * to the methodNames() method is the same as passing
             * ReflectionMethod::IS_FINAL to the methodNames()
             * method.
             */
            $this->determineReflectedClassesMethodNames(
                ReflectionMethod::IS_FINAL
            ),
            $this->reflectionTestInstance()->methodNames(
                Reflection::IS_FINAL
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'methodNames',
                'return an array of the names of the final ' .
                'methods defined by the reflected class if the' .
                'ReflectionClass::IS_FINAL filter is specified'
            )
        );
    }
    /**
     * Test that the methodNames() method returns a numerically
     * indexed array of the names of the private methods defined
     * by the reflected class if the Reflection::IS_PRIVATE
     * filter is specified.
     *
     * @return void
     *
     */
    public function test_methodNames_returns_the_names_of_the_private_methods_defined_by_the_reflected_class_if_the_ReflectionIS_PRIVATE_filter_is_specified(): void
    {
        $this->assertEquals(
            /**
             * ReflectionMethod::IS_PRIVATE is used intentionally to
             * test that the effect of passing Reflection::IS_PRIVATE
             * to the methodNames() method is the same as passing
             * ReflectionMethod::IS_PRIVATE to the methodNames()
             * method.
             */
            $this->determineReflectedClassesMethodNames(
               ReflectionMethod::IS_PRIVATE
            ),
            $this->reflectionTestInstance()->methodNames(
                Reflection::IS_PRIVATE
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'methodNames',
                'return an array of the names of the private ' .
                'methods defined by the reflected class if the' .
                'ReflectionClass::IS_PRIVATE filter is specified'
            )
        );
    }

    /**
     * Test that the methodNames() method returns a numerically
     * indexed array of the names of the protected methods defined
     * by the reflected class if the Reflection::IS_PROTECTED
     * filter is specified.
     *
     * @return void
     *
     */
    public function test_methodNames_returns_the_names_of_the_protected_methods_defined_by_the_reflected_class_if_the_ReflectionIS_PROTECTED_filter_is_specified(): void
    {
        $this->assertEquals(
            /**
             * ReflectionMethod::IS_PROTECTED is used
             * intentionally to test that the effect of
             * passing Reflection::IS_PROTECTED to the
             * methodNames() method is the same as passing
             * ReflectionMethod::IS_PROTECTED to the
             * methodNames() method.
             */
            $this->determineReflectedClassesMethodNames(
                ReflectionMethod::IS_PROTECTED
            ),
            $this->reflectionTestInstance()->methodNames(
                Reflection::IS_PROTECTED
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'methodNames',
                'return an array of the names of the protected ' .
                'methods defined by the reflected class if the' .
                'ReflectionClass::IS_PROTECTED filter is specified'
            )
        );
    }

    /**
     * Test that the methodNames() method returns a numerically
     * indexed array of the names of the public methods defined
     * by the reflected class if the Reflection::IS_PUBLIC
     * filter is specified.
     *
     * @return void
     *
     */
    public function test_methodNames_returns_the_names_of_the_public_methods_defined_by_the_reflected_class_if_the_ReflectionIS_PUBLIC_filter_is_specified(): void
    {
        $this->assertEquals(
            /**
             * ReflectionMethod::IS_PUBLIC is used intentionally to
             * test that the effect of passing Reflection::IS_PUBLIC
             * to the methodNames() method is the same as passing
             * ReflectionMethod::IS_PUBLIC to the methodNames()
             * method.
             */
            $this->determineReflectedClassesMethodNames(
                ReflectionMethod::IS_PUBLIC
            ),
            $this->reflectionTestInstance()->methodNames(
                Reflection::IS_PUBLIC
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'methodNames',
                'return an array of the names of the public ' .
                'methods defined by the reflected class if the' .
                'ReflectionClass::IS_PUBLIC filter is specified'
            )
        );
    }

    /**
     * Test that the methodNames() method returns a numerically
     * indexed array of the names of the static methods defined
     * by the reflected class if the Reflection::IS_STATIC
     * filter is specified.
     *
     * @return void
     *
     */
    public function test_methodNames_returns_the_names_of_the_static_methods_defined_by_the_reflected_class_if_the_ReflectionIS_STATIC_filter_is_specified(): void
    {
        $this->assertEquals(
            /**
             * ReflectionMethod::IS_STATIC is used intentionally to
             * test that the effect of passing Reflection::IS_STATIC
             * to the methodNames() method is the same as passing
             * ReflectionMethod::IS_STATIC to the methodNames()
             * method.
             */
            $this->determineReflectedClassesMethodNames(
                ReflectionMethod::IS_STATIC
            ),
            $this->reflectionTestInstance()->methodNames(
                Reflection::IS_STATIC
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'methodNames',
                'return an array of the names of the static ' .
                'methods defined by the reflected class if the' .
                'ReflectionClass::IS_STATIC filter is specified'
            )
        );
    }

    /**
     * Test that the value of the Reflection::IS_ABSTRACT
     * constant is equal to the value of the
     * ReflectionMethod::IS_ABSTRACT constant.
     *
     * @return void
     *
     */
    public function test_ReflectionIS_ABSTRACT_constant_is_equal_to_ReflectionMethodIS_ABSTRACT_constant(): void
    {
        $this->assertEquals(
            ReflectionMethod::IS_ABSTRACT,
            Reflection::IS_ABSTRACT,
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                '',
                'The value of the Reflection::IS_ABSTRACT constant ' .
                'must be equal to the value of the ' .
                'ReflectionMethod::IS_ABSTRACT constant'
            )
        );
    }

    /**
     * Test that the value of the Reflection::IS_FINAL constant
     * is equal to the value of the ReflectionMethod::IS_FINAL
     * constant.
     *
     * @return void
     *
     */
    public function test_ReflectionIS_FINAL_constant_is_equal_to_ReflectionMethodIS_FINAL_constant(): void
    {
        $this->assertEquals(
            ReflectionMethod::IS_FINAL,
            Reflection::IS_FINAL,
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                '',
                'The value of the Reflection::IS_FINAL constant ' .
                'must be equal to the value of the ' .
                'ReflectionMethod::IS_FINAL constant'
            )
        );
    }

    /**
     * Test that the value of the Reflection::IS_PRIVATE constant
     * is equal to the value of the ReflectionMethod::IS_PRIVATE
     * constant.
     *
     * @return void
     *
     */
    public function test_ReflectionIS_PRIVATE_constant_is_equal_to_ReflectionMethodIS_PRIVATE_constant(): void
    {
        $this->assertEquals(
            ReflectionMethod::IS_PRIVATE,
            Reflection::IS_PRIVATE,
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                '',
                'The value of the Reflection::IS_PRIVATE constant ' .
                'must be equal to the value of the ' .
                'ReflectionMethod::IS_PRIVATE constant'
            )
        );
    }

    /**
     * Test that the value of the Reflectionvalue::IS_PROTECTED
     * constant is equal to the value of the
     * ReflectionMethod::IS_PROTECTED constant.
     *
     * @return void
     *
     */
    public function test_ReflectionIS_PROTECTED_constant_is_equal_to_ReflectionMethodIS_PROTECTED_constant(): void
    {
        $this->assertEquals(
            ReflectionMethod::IS_PROTECTED,
            Reflection::IS_PROTECTED,
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                '',
                'The value of the Reflection::IS_PROTECTED ' .
                'constant must be equal to the value of the ' .
                'ReflectionMethod::IS_PROTECTED constant'
            )
        );
    }

    /**
     * Test that the value of the Reflection::IS_PUBLIC constant
     * is equal to the value of the ReflectionMethod::IS_PUBLIC
     * constant.
     *
     * @return void
     *
     */
    public function test_ReflectionIS_PUBLIC_constant_is_equal_to_ReflectionMethodIS_PUBLIC_constant(): void
    {
        $this->assertEquals(
            ReflectionMethod::IS_PUBLIC,
            Reflection::IS_PUBLIC,
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                '',
                'The value of the Reflection::IS_PUBLIC constant ' .
                'must be equal to the value of the ' .
                'ReflectionMethod::IS_PUBLIC constant'
            )
        );
    }

    /**
     * Test that the value of the Reflection::IS_STATIC constant
     * is equal to the value of the ReflectionMethod::IS_STATIC
     * constant.
     *
     * @return void
     *
     */
    public function test_ReflectionIS_STATIC_constant_is_equal_to_ReflectionMethodIS_STATIC_constant(): void
    {
        $this->assertEquals(
            ReflectionMethod::IS_STATIC,
            Reflection::IS_STATIC,
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                '',
                'The value of the Reflection::IS_STATIC constant ' .
                'must be equal to the value of the ' .
                'ReflectionMethod::IS_STATIC constant'
            )
        );
    }

    /**
     * Test that the methodParameterNames() method returns a
     * numerically indexed array of the names of the parameters
     * defined by the specified method of the reflected class or
     * object instance.
     *
     * @return void
     *
     */
    public function test_methodParameterNames_returns_a_numerically_indexed_array_of_the_names_of_the_parameters_defined_by_the_specified_method(): void
    {
        $methodName = $this->randomMethodName();
        $this->assertEquals(
            $this->determineReflectedClassesMethodParameterNames(
                $methodName
            ),
            $this->reflectionTestInstance()->methodParameterNames(
                $methodName
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'methodNames',
                'return a numerically indexed array of the names ' .
                'of the parameters defined by the specified method ' .
                'of the reflected class or object instance'
            )
        );
    }

    /**
     * Test that the methodParameterTypes() method returns an
     * associatively indexed array of numerically indexed arrays
     * of strings indicating the types of the parameters defined
     * by the specified method of the reflected class or object
     * instance.
     *
     * @return void
     *
     */
    public function test_methodParameterTypes_returns_a_numerically_indexed_array_of_the_types_expected_by_the_parameters_defined_by_the_specified_method(): void
    {
        $methodNames = $this->determineReflectedClassesMethodNames();
        $methodName = $this->randomMethodName();
        $this->assertEquals(
            $this->determineReflectedClassesMethodParameterTypes(
                $methodName
            ),
            $this->reflectionTestInstance()->methodParameterTypes(
                $methodName
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'methodParameterTypes',
                'return an associatively indexed array of ' .
                'numerically indexed arrays of strings indicating '.
                'the types of the parameters expected by ' .
                'the specified method of the reflected class ' .
                'or object instance'
            )
        );
    }

    /**
     * Test that the propertyNames() method returns a numerically
     * indexed array of the names of all the properties defined by
     * the reflected class if no filter is specified.
     *
     * @return void
     *
     */
    public function test_propertyNames_returns_the_names_of_all_the_properties_defined_by_the_reflected_class_if_no_filter_is_specified(): void
    {
        $this->assertEquals(
            $this->determineReflectedClassesPropertyNames(),
            $this->reflectionTestInstance()->propertyNames(),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'methodNames',
                'return an array of the names of all of the ' .
                'properties defined by the reflected class if ' .
                'no filer is specified'
            )
        );
    }

    /**
     * Test that the propertyNames() method returns an empty
     * array the Reflection::IS_ABSTRACT filter is specified.
     *
     * @return void
     *
     */
    public function test_propertyNames_returns_the_names_of_the_abstract_properties_defined_by_the_reflected_class_if_the_ReflectionIS_ABSTRACT_filter_is_specified(): void
    {
        $this->assertEmpty(
            /**
             * ReflectionMethod::IS_ABSTRACT is used intentionally to
             * test that the effect of passing Reflection::IS_ABSTRACT
             * to the propertyNames() method is the same as passing
             * ReflectionMethod::IS_ABSTRACT to the propertyNames()
             * method.
             */
            $this->reflectionTestInstance()->propertyNames(
                Reflection::IS_ABSTRACT
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'propertyNames',
                'return an empty array if the ' .
                'ReflectionClass::IS_ABSTRACT filter is specified'
            )
        );
    }

    /**
     * Test that the propertyNames() method returns a numerically
     * indexed array of the names of the final properties defined
     * by the reflected class if the Reflection::IS_FINAL
     * filter is specified.
     *
     * @return void
     *
     */
    public function test_propertyNames_returns_the_names_of_the_final_properties_defined_by_the_reflected_class_if_the_ReflectionIS_FINAL_filter_is_specified(): void
    {
        $this->assertEquals(
            /**
             * ReflectionMethod::IS_FINAL is used intentionally to
             * test that the effect of passing Reflection::IS_FINAL
             * to the propertyNames() method is the same as passing
             * ReflectionMethod::IS_FINAL to the propertyNames()
             * method.
             */
            $this->determineReflectedClassesPropertyNames(
                ReflectionMethod::IS_FINAL
            ),
            $this->reflectionTestInstance()->propertyNames(
                Reflection::IS_FINAL
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'propertyNames',
                'return an array of the names of the final ' .
                'properties defined by the reflected class if the' .
                'ReflectionClass::IS_FINAL filter is specified'
            )
        );
    }
    /**
     * Test that the propertyNames() method returns a numerically
     * indexed array of the names of the private properties defined
     * by the reflected class if the Reflection::IS_PRIVATE
     * filter is specified.
     *
     * @return void
     *
     */
    public function test_propertyNames_returns_the_names_of_the_private_properties_defined_by_the_reflected_class_if_the_ReflectionIS_PRIVATE_filter_is_specified(): void
    {
        $this->assertEquals(
            /**
             * ReflectionMethod::IS_PRIVATE is used intentionally to
             * test that the effect of passing Reflection::IS_PRIVATE
             * to the propertyNames() method is the same as passing
             * ReflectionMethod::IS_PRIVATE to the propertyNames()
             * method.
             */
            $this->determineReflectedClassesPropertyNames(
               ReflectionMethod::IS_PRIVATE
            ),
            $this->reflectionTestInstance()->propertyNames(
                Reflection::IS_PRIVATE
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'propertyNames',
                'return an array of the names of the private ' .
                'properties defined by the reflected class if the' .
                'ReflectionClass::IS_PRIVATE filter is specified'
            )
        );
    }

    /**
     * Test that the propertyNames() method returns a numerically
     * indexed array of the names of the protected properties defined
     * by the reflected class if the Reflection::IS_PROTECTED
     * filter is specified.
     *
     * @return void
     *
     */
    public function test_propertyNames_returns_the_names_of_the_protected_properties_defined_by_the_reflected_class_if_the_ReflectionIS_PROTECTED_filter_is_specified(): void
    {
        $this->assertEquals(
            /**
             * ReflectionMethod::IS_PROTECTED is used
             * intentionally to test that the effect of
             * passing Reflection::IS_PROTECTED to the
             * propertyNames() method is the same as passing
             * ReflectionMethod::IS_PROTECTED to the
             * propertyNames() method.
             */
            $this->determineReflectedClassesPropertyNames(
                ReflectionMethod::IS_PROTECTED
            ),
            $this->reflectionTestInstance()->propertyNames(
                Reflection::IS_PROTECTED
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'propertyNames',
                'return an array of the names of the protected ' .
                'properties defined by the reflected class if the' .
                'ReflectionClass::IS_PROTECTED filter is specified'
            )
        );
    }

    /**
     * Test that the propertyNames() method returns a numerically
     * indexed array of the names of the public properties defined
     * by the reflected class if the Reflection::IS_PUBLIC
     * filter is specified.
     *
     * @return void
     *
     */
    public function test_propertyNames_returns_the_names_of_the_public_properties_defined_by_the_reflected_class_if_the_ReflectionIS_PUBLIC_filter_is_specified(): void
    {
        $this->assertEquals(
            /**
             * ReflectionMethod::IS_PUBLIC is used intentionally to
             * test that the effect of passing Reflection::IS_PUBLIC
             * to the propertyNames() method is the same as passing
             * ReflectionMethod::IS_PUBLIC to the propertyNames()
             * method.
             */
            $this->determineReflectedClassesPropertyNames(
                ReflectionMethod::IS_PUBLIC
            ),
            $this->reflectionTestInstance()->propertyNames(
                Reflection::IS_PUBLIC
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'propertyNames',
                'return an array of the names of the public ' .
                'properties defined by the reflected class if the' .
                'ReflectionClass::IS_PUBLIC filter is specified'
            )
        );
    }

    /**
     * Test that the propertyNames() method returns a numerically
     * indexed array of the names of the static properties defined
     * by the reflected class if the Reflection::IS_STATIC
     * filter is specified.
     *
     * @return void
     *
     */
    public function test_propertyNames_returns_the_names_of_the_static_properties_defined_by_the_reflected_class_if_the_ReflectionIS_STATIC_filter_is_specified(): void
    {
        $this->assertEquals(
            /**
             * ReflectionMethod::IS_STATIC is used intentionally to
             * test that the effect of passing Reflection::IS_STATIC
             * to the propertyNames() method is the same as passing
             * ReflectionMethod::IS_STATIC to the propertyNames()
             * method.
             */
            $this->determineReflectedClassesPropertyNames(
                ReflectionMethod::IS_STATIC
            ),
            $this->reflectionTestInstance()->propertyNames(
                Reflection::IS_STATIC
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'propertyNames',
                'return an array of the names of the static ' .
                'properties defined by the reflected class if the' .
                'ReflectionClass::IS_STATIC filter is specified'
            )
        );
    }

    /**
     * Test that the propertyTypes() method returns an associatively
     * indexed array of numerically indexed arrays of strings
     * indicating the types accepted by all of the properties declared
     * by the reflected class or object instance if no filter is
     * specified.
     *
     * @return void
     *
     */
    public function test_PropertyTypes_returns_an_associatively_indexed_array_of_arrays_of_the_types_of_all_the_properties_declared_by_the_reflected_class_or_object_instance_if_no_filter_is_specified(): void
    {
        $this->assertEquals(
            $this->determineReflectedClassesPropertyTypes(),
            $this->reflectionTestInstance()->propertyTypes(),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'propertyTypes',
                'return an associatively indexed array of ' .
                'numerically indexed arrays of strings indicating '.
                'the types accepted by all of the properties ' .
                'declared by the reflected class or object ' .
                'instance if no filter is specified.'
            )
        );
    }



    /**
     * Test that the propertyTypes() method returns an empty array
     * if the Reflection::IS_ABSTRACT filter is specified.
     *
     * @return void
     *
     */
    public function test_propertyTypes_returns_an_empty_array_if_the_ReflectionIS_ABSTRACT_filter_is_specified(): void
    {
        $this->assertEmpty(
            $this->reflectionTestInstance()->propertyTypes(
                Reflection::IS_ABSTRACT
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'propertyTypes',
                'An empty array if the' .
                'ReflectionClass::IS_ABSTRACT filter is specified'
            )
        );
    }

    /**
     * Test that the propertyTypes() method returns an associatively
     * indexed array of numerically indexed arrays of strings
     * representing the types of the final properties declared
     * by the reflected class if the Reflection::IS_FINAL
     * filter is specified.
     *
     * @return void
     *
     */
    public function test_propertyTypes_returns_the_types_of_the_final_properties_declared_by_the_reflected_class_if_the_ReflectionIS_FINAL_filter_is_specified(): void
    {
        $this->assertEquals(
            /**
             * ReflectionMethod::IS_FINAL is used intentionally to
             * test that the effect of passing Reflection::IS_FINAL
             * to the propertyTypes() method is the same as passing
             * ReflectionMethod::IS_FINAL to the propertyTypes()
             * method.
             */
            $this->determineReflectedClassesPropertyTypes(
                ReflectionMethod::IS_FINAL
            ),
            $this->reflectionTestInstance()->propertyTypes(
                Reflection::IS_FINAL
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'propertyTypes',
                'return an array of the types of the final ' .
                'properties declared by the reflected class if the' .
                'ReflectionClass::IS_FINAL filter is specified'
            )
        );
    }

    /**
     * Test that the propertyTypes() method returns an associatively
     * indexed array of numerically indexed arrays of strings
     * representing the types of the private properties declared
     * by the reflected class if the Reflection::IS_PRIVATE
     * filter is specified.
     *
     * @return void
     *
     */
    public function test_propertyTypes_returns_the_types_of_the_private_properties_declared_by_the_reflected_class_if_the_ReflectionIS_PRIVATE_filter_is_specified(): void
    {
        $this->assertEquals(
            /**
             * ReflectionMethod::IS_PRIVATE is used intentionally to
             * test that the effect of passing Reflection::IS_PRIVATE
             * to the propertyTypes() method is the same as passing
             * ReflectionMethod::IS_PRIVATE to the propertyTypes()
             * method.
             */
            $this->determineReflectedClassesPropertyTypes(
               ReflectionMethod::IS_PRIVATE
            ),
            $this->reflectionTestInstance()->propertyTypes(
                Reflection::IS_PRIVATE
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'propertyTypes',
                'return an array of the types of the private ' .
                'properties declared by the reflected class if the' .
                'ReflectionClass::IS_PRIVATE filter is specified'
            )
        );
    }

    /**
     * Test that the propertyTypes() method returns an associatively
     * indexed array of numerically indexed arrays of strings
     * representing the types of the protected properties declared
     * by the reflected class if the Reflection::IS_PROTECTED
     * filter is specified.
     *
     * @return void
     *
     */
    public function test_propertyTypes_returns_the_types_of_the_protected_properties_declared_by_the_reflected_class_if_the_ReflectionIS_PROTECTED_filter_is_specified(): void
    {
        $this->assertEquals(
            /**
             * ReflectionMethod::IS_PROTECTED is used
             * intentionally to test that the effect of
             * passing Reflection::IS_PROTECTED to the
             * propertyTypes() method is the same as passing
             * ReflectionMethod::IS_PROTECTED to the
             * propertyTypes() method.
             */
            $this->determineReflectedClassesPropertyTypes(
                ReflectionMethod::IS_PROTECTED
            ),
            $this->reflectionTestInstance()->propertyTypes(
                Reflection::IS_PROTECTED
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'propertyTypes',
                'return an array of the types of the protected ' .
                'properties declared by the reflected class if the' .
                'ReflectionClass::IS_PROTECTED filter is specified'
            )
        );
    }

    /**
     * Test that the propertyTypes() method returns an associatively
     * indexed array of numerically indexed arrays of strings
     * representing the types of the public properties declared
     * by the reflected class if the Reflection::IS_PUBLIC
     * filter is specified.
     *
     * @return void
     *
     */
    public function test_propertyTypes_returns_the_types_of_the_public_properties_declared_by_the_reflected_class_if_the_ReflectionIS_PUBLIC_filter_is_specified(): void
    {
        $this->assertEquals(
            /**
             * ReflectionMethod::IS_PUBLIC is used intentionally to
             * test that the effect of passing Reflection::IS_PUBLIC
             * to the propertyTypes() method is the same as passing
             * ReflectionMethod::IS_PUBLIC to the propertyTypes()
             * method.
             */
            $this->determineReflectedClassesPropertyTypes(
                ReflectionMethod::IS_PUBLIC
            ),
            $this->reflectionTestInstance()->propertyTypes(
                Reflection::IS_PUBLIC
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'propertyTypes',
                'return an array of the types of the public ' .
                'properties declared by the reflected class if the' .
                'ReflectionClass::IS_PUBLIC filter is specified'
            )
        );
    }

    /**
     * Test that the propertyTypes() method returns an associatively
     * indexed array of numerically indexed arrays of strings
     * representing the types of the static properties declared
     * by the reflected class if the Reflection::IS_STATIC
     * filter is specified.
     *
     * @return void
     *
     */
    public function test_propertyTypes_returns_the_types_of_the_static_properties_declared_by_the_reflected_class_if_the_ReflectionIS_STATIC_filter_is_specified(): void
    {
        $this->assertEquals(
            /**
             * ReflectionMethod::IS_STATIC is used intentionally to
             * test that the effect of passing Reflection::IS_STATIC
             * to the propertyTypes() method is the same as passing
             * ReflectionMethod::IS_STATIC to the propertyTypes()
             * method.
             */
            $this->determineReflectedClassesPropertyTypes(
                ReflectionMethod::IS_STATIC
            ),
            $this->reflectionTestInstance()->propertyTypes(
                Reflection::IS_STATIC
            ),
            $this->testFailedMessage(
                $this->reflectionTestInstance(),
                'propertyTypes',
                'return an array of the types of the static ' .
                'properties declared by the reflected class if the' .
                'ReflectionClass::IS_STATIC filter is specified'
            )
        );
    }
}

/*
 *
var_dump($parameterOrProperty);
var_dump(is_object($this->reflectedClass()) ? $this->reflectedClass()::class : $this->reflectedClass());
var_dump($types);
 */
