<?php

use SamHolman\App;

class IndexText extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $input = Mockery::mock('SamHolman\Input');
        $view  = App::make('SamHolman\View');

        $repo = Mockery::mock('SamHolman\Article\Service');
        $repo->shouldReceive('findAll')->andReturn(
            array(App::make('SamHolman\Article\Entity', array('Title', 'Content')))
        );

        $controller = App::make('SamHolman\Controllers\Index', array($input, $view, $repo));
        $output = $controller->get();

        $this->assertNotEmpty($output);
        $this->assertInternalType('array', $view->articles);
        $this->assertCount(1, $view->articles);
        $this->assertEquals('Title', $view->articles[0]->getTitle());
    }
}
