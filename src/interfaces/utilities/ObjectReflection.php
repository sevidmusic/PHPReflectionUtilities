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
 * $id = new \Darling\PHPReflectionUtilities\classes\strings\Id();
 *
 * $objectReflection = new \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection($id);
 *
 * var_dump($objectReflection->propertyValues());
 *
 * // example output:
 * array(2) {
 *   ["text"]=>
 *   object(Darling\PHPReflectionUtilities\classes\strings\AlphanumericText)#2 (2) {
 *     ["string":"Darling\PHPReflectionUtilities\classes\strings\Text":private]=>
 *     string(63) "RvG52EFsDA2C9CQMP8yrtZjPhyBV2mexyENWqcAngqlkfq6voBsbHniQpg3G7Tr"
 *     ["text":"Darling\PHPReflectionUtilities\classes\strings\SafeText":private]=>
 *     object(Darling\PHPReflectionUtilities\classes\strings\Text)#4 (1) {
 *       ["string":"Darling\PHPReflectionUtilities\classes\strings\Text":private]=>
 *       string(63) "rvG52EFsDA2C9CQMP8yrtZjPhyBV2mexyENWqcAngqlkfq6voBsbHniQpg3G7Tr"
 *     }
 *   }
 *   ["string"]=>
 *   string(63) "RvG52EFsDA2C9CQMP8yrtZjPhyBV2mexyENWqcAngqlkfq6voBsbHniQpg3G7Tr"
 * }
 *
 * ```
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
     * var_dump($reflectedObject->determinePropertyValues());
     *
     * // example output:
     * array(2) {
     *   ["text"]=>
     *   object(Darling\PHPReflectionUtilities\classes\strings\AlphanumericText)#2 (2) {
     *     ["string":"Darling\PHPReflectionUtilities\classes\strings\Text":private]=>
     *     string(71) "EQGZrDimpUqWfE2dIJttyRdOmXnuRpsCZ2yxj1z97M3voCWiXAWJl5QnDgKFKfsX8hNsNIe"
     *     ["text":"Darling\PHPReflectionUtilities\classes\strings\SafeText":private]=>
     *     object(Darling\PHPReflectionUtilities\classes\strings\Text)#4 (1) {
     *       ["string":"Darling\PHPReflectionUtilities\classes\strings\Text":private]=>
     *       string(71) "eQGZrDimpUqWfE2dIJttyRdOmXnuRpsCZ2yxj1z97M3voCWiXAWJl5QnDgKFKfsX8hNsNIe"
     *     }
     *   }
     *   ["string"]=>
     *   string(71) "EQGZrDimpUqWfE2dIJttyRdOmXnuRpsCZ2yxj1z97M3voCWiXAWJl5QnDgKFKfsX8hNsNIe"
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
     * var_dump($reflectionObject->reflectedObject());
     *
     * // example output:
     * object(Darling\PHPReflectionUtilities\classes\strings\Id)#3 (2) {
     *   ["string":"Darling\PHPReflectionUtilities\classes\strings\Text":private]=>
     *   string(71) "EQGZrDimpUqWfE2dIJttyRdOmXnuRpsCZ2yxj1z97M3voCWiXAWJl5QnDgKFKfsX8hNsNIe"
     *   ["text":"Darling\PHPReflectionUtilities\classes\strings\SafeText":private]=>
     *   object(Darling\PHPReflectionUtilities\classes\strings\AlphanumericText)#2 (2) {
     *     ["string":"Darling\PHPReflectionUtilities\classes\strings\Text":private]=>
     *     string(71) "EQGZrDimpUqWfE2dIJttyRdOmXnuRpsCZ2yxj1z97M3voCWiXAWJl5QnDgKFKfsX8hNsNIe"
     *     ["text":"Darling\PHPReflectionUtilities\classes\strings\SafeText":private]=>
     *     object(Darling\PHPReflectionUtilities\classes\strings\Text)#4 (1) {
     *       ["string":"Darling\PHPReflectionUtilities\classes\strings\Text":private]=>
     *       string(71) "eQGZrDimpUqWfE2dIJttyRdOmXnuRpsCZ2yxj1z97M3voCWiXAWJl5QnDgKFKfsX8hNsNIe"
     *     }
     *   }
     * }
     *
     * ```
     *
     */
     public function reflectedObject(): object;

}

