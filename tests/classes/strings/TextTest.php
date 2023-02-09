<?php

namespace tests\classes\strings;

use Darling\PHPReflectionUtilities\classes\strings\Text;
use tests\RoadyTest;
use tests\interfaces\strings\TextTestTrait;

class TextTest extends RoadyTest
{

    /**
     * The TextTestTrait defines common tests for implementations of
     * the Darling\PHPReflectionUtilities\interfaces\strings\Text interface.
     *
     * @see TextTestTrait
     */
    use TextTestTrait;

    protected function setUp(): void
    {
        $string = $this->randomChars();
        $this->setExpectedString($string);
        $this->setTextTestInstance(new Text($string));
    }

}
