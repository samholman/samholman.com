<?php

use SamHolman\Base\IoC;

class AboutTest extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $view       = IoC::make('SamHolman\Base\View');
        $controller = IoC::make('SamHolman\Site\Controllers\About', [$view]);

        try {
            $this->assertNotEmpty($controller->get());
        }
        catch(SamHolman\Base\Exceptions\TemplateNotFoundException $e) {}

        $this->assertEquals('About', $view->title);
    }
}
