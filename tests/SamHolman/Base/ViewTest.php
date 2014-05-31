<?php

use SamHolman\Base\View,
    SamHolman\Base\Exceptions\TemplateNotFoundException;

class ViewTest extends PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        $view = new View();

        try {
            $view->make('template', ['var' => '#value']);
            $this->fail("Didn't throw expected exception.");
        }
        catch (TemplateNotFoundException $e) {}

        $this->assertFalse(isset($view->notSet));
        $this->assertEquals('#value', $view->var);
        $this->assertEquals('<h1>value</h1>', trim($view->markdown($view->var)));
    }
}
