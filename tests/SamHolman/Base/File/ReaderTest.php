<?php

use SamHolman\Base\File\Reader;

class ReaderTest extends PHPUnit_Framework_TestCase
{
    public function testExists()
    {
        $reader = new Reader();

        $this->assertFalse($reader->exists('/tmp/blah'));
        $this->assertTrue($reader->exists(__FILE__));
    }

    public function testRead()
    {
        $reader = new Reader();

        $this->assertNotEmpty($reader->read(__FILE__));
    }
}
