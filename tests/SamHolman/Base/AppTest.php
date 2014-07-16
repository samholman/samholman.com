<?php

use SamHolman\Base\App;

class AppTest extends PHPUnit_Framework_TestCase
{
    public function testRun()
    {
        $router = Mockery::mock('SamHolman\Base\Router');
        $router->shouldReceive('route')->andReturn('Output');

        $input  = Mockery::mock('SamHolman\Base\Input');
        $input->shouldReceive('getRequestPath');

        $app = new App($router, $input);
        $this->assertInstanceOf('SamHolman\Base\App', $app->run());

        return $app;
    }

    /**
     * @depends testRun
     */
    public function testRender(App $app)
    {
        $this->assertEquals('Output', $app->render());
    }
}
