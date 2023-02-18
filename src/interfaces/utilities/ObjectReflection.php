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
     *
     * ```
     *
     */
     public function reflectedObject(): object;

}

