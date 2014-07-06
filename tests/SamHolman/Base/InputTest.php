<?php

use SamHolman\Base\Input;

class InputTest extends PHPUnit_Framework_TestCase
{
    public function testGetRequestPath()
    {
        $input = new Input();
        $this->assertNull($input->getRequestPath());

        $_SERVER['REQUEST_URI'] = '/hello/world?test=true';
        $this->assertEquals('/hello/world', $input->getRequestPath());
    }

    public function testGet()
    {
        $input = new Input();
        $this->assertInternalType('array', $input->get());
        $this->assertNull($input->get('test'));

        $_GET['test'] = 'hello';
        $this->assertEquals('hello', $input->get('test'));
    }

    public function testPost()
    {
        $input = new Input();
        $this->assertInternalType('array', $input->post());
        $this->assertNull($input->post('test'));

        $_POST['test'] = 'hello';
        $this->assertEquals('hello', $input->post('test'));
    }

    public function testRaw()
    {
        $input = new Input();
        $this->assertEmpty($input->raw());
    }

    public function testJson()
    {
        $input = new Input();
        $this->assertEmpty($input->json());
    }
}
