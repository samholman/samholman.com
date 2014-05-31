<?php

use SamHolman\App;

class IndexText extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $response = Mockery::mock('SamHolman\Response');
        $view     = App::make('SamHolman\View');

        $service = Mockery::mock('SamHolman\Article\Service');
        $service->shouldReceive('getArticles')->andReturn(
            [App::make('SamHolman\Article\Entity', ['slug', new \DateTime(), 'Title', 'Content'])]
        );

        $controller = App::make('SamHolman\Controllers\Index', [$response, $view, $service]);
        $output     = $controller->get();

        $this->assertNotEmpty($output);
        $this->assertInternalType('array', $view->articles);
        $this->assertCount(1, $view->articles);
        $this->assertEquals('Title', $view->articles[0]->getTitle());
    }
}
