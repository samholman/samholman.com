<?php

use SamHolman\Base\App;

class AboutTest extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $view       = App::make('SamHolman\Base\View');
        $controller = App::make('SamHolman\Site\Controllers\About', [$view]);

        $this->assertNotEmpty($controller->get());
        $this->assertEquals('About', $view->title);
    }
}
