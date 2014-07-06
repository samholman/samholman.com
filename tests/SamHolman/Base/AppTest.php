<?php

use SamHolman\Base\App,
    SamHolman\Base\Input;

class AppTest extends PHPUnit_Framework_TestCase
{
    public function testPageNotFound()
    {
        $this->setExpectedException('SamHolman\Base\Exceptions\PageNotFoundException');

        $app = new App(new Input());
        $app->run();
    }

    public function testRender()
    {
        $app = new App(new Input());
        $this->assertEmpty($app->render());
    }

    public function testNormalRoute()
    {
        App::register('/test-path', 'TestController');

        $input = Mockery::mock('SamHolman\Base\Input');
        $input->shouldReceive('getRequestPath')->andReturn('/test-path');

        $app = new App($input);
        $this->assertEquals('Output', $app->run()->render());
    }

    public function testRegexRoute()
    {
        App::register('regex:/^\/test$/', 'TestController');

        $input = Mockery::mock('SamHolman\Base\Input');
        $input->shouldReceive('getRequestPath')->andReturn('/test');

        $app = new App($input);
        $this->assertEquals('Output', $app->run()->render());
    }
}

class TestController
{
    public function get()
    {
        return 'Output';
    }
}
