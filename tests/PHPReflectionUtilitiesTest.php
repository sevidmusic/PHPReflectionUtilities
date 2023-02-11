<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use Darling\PHPUnitTestUtilities\traits\PHPUnitConfigurationTests;
use Darling\PHPUnitTestUtilities\traits\PHPUnitTestMessages;
use Darling\PHPUnitTestUtilities\traits\PHPUnitRandomValues;

/**
 * Defines common methods that may be useful to all
 * PHPReflectionUtilities test classes.
 *
 * All PHPReflectionUtilities test classes must extend from
 * this class.
 *
 * This class also serves as an example of how the traits
 * provided by this library can be used in a phpunit test
 * class.
 *
 */
class PHPReflectionUtilitiesTest extends TestCase
{
    use PHPUnitConfigurationTests;
    use PHPUnitTestMessages;
    use PHPUnitRandomValues;
}


