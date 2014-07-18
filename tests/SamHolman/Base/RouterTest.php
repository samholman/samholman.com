<?php

use SamHolman\Base\Router;

class RouterTest extends PHPUnit_Framework_TestCase
{
    public function testPageNotFound()
    {
        $this->setExpectedException('SamHolman\Base\Exceptions\PageNotFoundException');

        $router = new Router();
        $router->route('get', '/test');
    }

    public function testRoute()
    {
        Router::register('/test-path', 'TestController');

        $router = new Router();
        $this->assertEquals('Get output', $router->route('get', '/test-path'));
    }

    public function testRegexRoute()
    {
        Router::register('regex:/^\/test$/', 'TestController');

        $router = new Router();
        $this->assertEquals('Get output', $router->route('get', '/test'));
    }

    public function testPostRoute()
    {
        Router::register('/test-path', 'TestController');

        $router = new Router();
        $this->assertEquals('Post output', $router->route('post', '/test-path'));
    }
}

class TestController
{
    public function get()
    {
        return 'Get output';
    }

    public function post()
    {
        return 'Post output';
    }
}

