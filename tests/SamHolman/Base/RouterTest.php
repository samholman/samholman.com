<?php

use SamHolman\Base\Router;

class RouterTest extends PHPUnit_Framework_TestCase
{
    public function testPageNotFound()
    {
        $this->setExpectedException('SamHolman\Base\Exceptions\PageNotFoundException');

        $router = new Router();
        $router->route('/test');
    }

    public function testRoute()
    {
        Router::register('/test-path', 'TestController');

        $router = new Router();
        $this->assertEquals('Output', $router->route('/test-path'));
    }

    public function testRegexRoute()
    {
        Router::register('regex:/^\/test$/', 'TestController');

        $router = new Router();
        $this->assertEquals('Output', $router->route('/test'));
    }
}

class TestController
{
    public function get()
    {
        return 'Output';
    }
}
