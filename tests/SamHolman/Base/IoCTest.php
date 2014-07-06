<?php

use SamHolman\Base\IoC;

class IoCTest extends PHPUnit_Framework_TestCase
{
    public function testBind()
    {
        $this->assertNull(IoC::bind('TestInterface', function() {}));
    }

    public function testMakeObject()
    {
        $this->assertInstanceOf('TestObject', IoC::make('TestObject'));
    }

    public function testMakeInterface()
    {
        IoC::bind('TestInterface', function() {
            return IoC::make('TestObject');
        });

        $object = IoC::make('TestObjectWithConstructor');
        $this->assertInstanceOf('TestObjectWithConstructor', $object);
        $this->assertInstanceOf('TestObject', $object->testObject);
        $this->assertInstanceOf('TestObject', $object->testInterface);
    }
}

interface TestInterface {}
class TestObject implements TestInterface {}

class TestObjectWithConstructor
{
    public function __construct(TestObject $testObject, TestInterface $testInterface)
    {
        $this->testObject    = $testObject;
        $this->testInterface = $testInterface;
    }
}
