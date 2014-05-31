<?php

use SamHolman\Base\App;

class IndexText extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $input = Mockery::mock('SamHolman\Base\Input');
        $input->shouldReceive('get')->with('page')->andReturn(0);

        $response   = Mockery::mock('SamHolman\Base\Response');
        $pagination = Mockery::mock('SamHolman\Base\Pagination');
        $pagination->shouldReceive('get');

        $view = App::make('SamHolman\Base\View');

        $service = Mockery::mock('SamHolman\Site\Article\Service');
        $service->shouldReceive('getArticles')->andReturn(
            [App::make('SamHolman\Site\Article\Entity', ['slug', new \DateTime(), 'Title', 'Content'])]
        );
        $service->shouldReceive('getArticleCount')->andReturn(1);

        $controller = App::make('SamHolman\Site\Controllers\Index', [$input, $response, $view, $pagination, $service]);
        $output     = $controller->get();

        $this->assertNotEmpty($output);
        $this->assertInternalType('array', $view->articles);
        $this->assertCount(1, $view->articles);
        $this->assertEquals('Title', $view->articles[0]->getTitle());
    }
}
