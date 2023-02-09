# PHPReflectionUtilities

A collection of php classes that can be used to aide in reflection with PHP.

# Installation

# Usage

### Darling\PHPReflectionUtilities\classes\utilities\Reflection

```
<?php

use Darling\PHPReflectionUtilities\classes\utilities\Reflection;

$class = Reflection::class;

$reflection = new Reflection(new \ReflectionClass($class));

var_dump($reflection->type());

```

### Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection

```
<?php

use Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;

$class = new ObjectReflection(new stdClass());

$reflection = new Reflection(new \ReflectionClass($class));

var_dump($reflection->type());


```

