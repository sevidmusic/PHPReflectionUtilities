<?php

namespace Darling\PHPReflectionUtilities\interfaces\utilities;

use Darling\PHPReflectionUtilities\interfaces\utilities\Reflection;

/**
 * An ObjectReflection is a Reflection that specifically reflects
 * an object instance.
 *
 * @example
 *
 * ```
 * var_dump($reflection->type());
 *
 * // example output:
 * object(Darling\PHPTextTypes\classes\strings\ClassString)#7 (1) {
 *   ["string":"Darling\PHPTextTypes\classes\strings\Text":private]=>
 *   string(65) "Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection"
 * }
 *
 * var_dump($reflection->methodNames());
 *
 * // example output:
 * array(14) {
 *   [0]=>
 *   string(11) "__construct"
 *   [1]=>
 *   string(14) "propertyValues"
 *   [2]=>
 *   string(15) "reflectedObject"
 *   [3]=>
 *   string(30) "addParentPropertyValuesToArray"
 *   [4]=>
 *   string(18) "newReflectionClass"
 *   [5]=>
 *   string(23) "addPropertyValueToArray"
 *   [6]=>
 *   string(11) "methodNames"
 *   [7]=>
 *   string(20) "methodParameterNames"
 *   [8]=>
 *   string(20) "methodParameterTypes"
 *   [9]=>
 *   string(13) "propertyNames"
 *   [10]=>
 *   string(13) "propertyTypes"
 *   [11]=>
 *   string(4) "type"
 *   [12]=>
 *   string(16) "reflectionMethod"
 *   [13]=>
 *   string(15) "reflectionClass"
 * }
 * ```
 *
 */
interface ObjectReflection extends Reflection
{

    /**
     * Return an associatively indexed array of the values of
     * the properties defined by the reflected object indexed
     * by property name.
     *
     * Note: Uninitialized properties will be assigned the value null.
     *
     * @return array<string, mixed>
     *
     * @example
     *
     * ```
     * var_dump($this->propertyValues());
     *
     * // example output:
     * array(2) {
     *   ["object"]=>
     *   object(stdClass)#2 (0) {
     *   }
     *   ["reflectionClass"]=>
     *   object(ReflectionClass)#4 (1) {
     *     ["name"]=>
     *     string(8) "stdClass"
     *   }
     * }
     *
     * ```
     *
     */
     public function propertyValues(): array;

    /**
     * Return the reflected object instance.
     *
     * @return object
     *
     * @example
     *
     * ```
     * var_dump($reflectedObject());
     *
     * // example output:
     * object(Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection)#3 (2) {
     *   ["reflectionClass":"Darling\PHPReflectionUtilities\classes\utilities\Reflection":private]=>
     *   object(ReflectionClass)#4 (1) {
     *     ["name"]=>
     *     string(8) "stdClass"
     *   }
     *
     * // example output:
     *   ["object":"Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection":private]=>
     *   object(stdClass)#2 (0) {
     *   }
     * }
     *
     * ```
     *
     */
     public function reflectedObject(): object;

}

