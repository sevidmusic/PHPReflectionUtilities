# PHPReflectionUtilities

A collection of php classes that can be used to aide in reflection
with PHP.

This library makes use of the following libraries:

[Darling\PHPUnitTestUtilities](https://github.com/sevidmusic/PHPUnitTestUtilities)
[Darling\PHPTextTypes](https://github.com/sevidmusic/PHPTextTypes)

- [Installation](#installation)

- [Classes](#classes)

  - [Darling\PHPTextTypes\Text](#darlingphpreflectionutilitiesreflection)
  - [Darling\PHPTextTypes\ClassString](#darlingreflectionutilitiesobjectreflection)

# Installation

```
composer require darling/php-reflection-utilities

```

# Classes

The following classes are provided by the PHPReflectionUtilities
library.

These classes can be used as is, or extended.

### [Darling\PHPReflectionUtilities\classes\utilities\Reflection](https://github.com/sevidmusic/PHPReflectionUtilities/blob/main/src/classes/utilities/Reflection.php)

 A Reflection can be used to get information about a reflected class
 or object instance.

 For example:

```
<?php

require __DIR__ . '/vendor/autoload.php';

use Darling\PHPReflectionUtilities\classes\utilities\Reflection;

$class = Reflection::class;

$reflection = new Reflection(new \ReflectionClass($class));

var_dump($reflection->type()->__toString());

var_dump($reflection->methodNames(Reflection::IS_PUBLIC));

var_dump($reflection->methodParameterNames('methodParameterNames'));

var_dump($reflection->methodParameterTypes('methodParameterTypes'));

var_dump($reflection->propertyNames(Reflection::IS_PRIVATE));

var_dump($reflection->propertyTypes(Reflection::IS_PRIVATE));

var_dump($reflection->type());

```

### [Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection](https://github.com/sevidmusic/PHPReflectionUtilities/blob/main/src/classes/utilities/ObjectReflection.php)

An ObjectReflection is a Reflection that specifically reflects an
object instance.

For example:

```
<?php

require __DIR__ . '/vendor/autoload.php';

use Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;

$instanceToReflect = new ArrayIterator(array('test1', 'test2', 'test3'));

$objectReflection = new ObjectReflection($instanceToReflect);

var_dump($objectReflection->propertyValues());

var_dump($objectReflection->methodNames());


```

