<?php

use SamHolman\Base\IoC;

class BlogTest extends PHPUnit_Framework_TestCase
{
    public function testIndex()
    {
        $config = Mockery::mock('SamHolman\Base\Config');
        $config->shouldReceive('get');

        $input = Mockery::mock('SamHolman\Base\Input');
        $input->shouldReceive('get')->with('page')->andReturn(0);

        $response   = Mockery::mock('SamHolman\Base\Http\Response');
        $pagination = Mockery::mock('SamHolman\Base\Pagination');
        $pagination->shouldReceive('get');

        $view = IoC::make('SamHolman\Base\View');

        $service = Mockery::mock('SamHolman\Site\Article\Service');
        $service->shouldReceive('getArticles')->andReturn(
            [IoC::make('SamHolman\Site\Article\Entity', ['slug', new \DateTime(), 'Title', 'Content'])]
        );
        $service->shouldReceive('getArticleCount')->andReturn(1);

        $controller = IoC::make('SamHolman\Site\Controllers\Blog', [$config, $input, $response, $view, $pagination, $service]);

        try {
            $this->assertNotEmpty($controller->index());
        }
        catch(SamHolman\Base\Exceptions\TemplateNotFoundException $e) {}

        $this->assertInternalType('array', $view->articles);
        $this->assertCount(1, $view->articles);
        $this->assertEquals('Title', $view->articles[0]->getTitle());
    }

    public function testArticle()
    {
        $config = Mockery::mock('SamHolman\Base\Config');
        $config->shouldReceive('get');

        $input = Mockery::mock('SamHolman\Base\Input');

        $response = Mockery::mock('SamHolman\Base\Http\Response');
        $response->shouldReceive('header');

        $pagination = Mockery::mock('SamHolman\Base\Pagination');

        $view = IoC::make('SamHolman\Base\View');

        $service = Mockery::mock('SamHolman\Site\Article\Service');
        $service->shouldReceive('getArticle')->with('article')->andReturn(
            IoC::make('SamHolman\Site\Article\Entity', ['slug', new \DateTime(), 'Title', 'Content'])
        );
        $service->shouldReceive('getArticle')->with('another-article')->andReturn(false);

        $controller = IoC::make('SamHolman\Site\Controllers\Blog', [$config, $input, $response, $view, $pagination, $service]);

        /**
         * First try a 404
         */
        try {
            $this->assertNotEmpty($controller->article('another-article'));
        }
        catch(SamHolman\Base\Exceptions\TemplateNotFoundException $e) {}

        $this->assertEmpty($view->article);

        /**
         * But this one should exist
         */
        try {
            $this->assertNotEmpty($controller->article('article'));
        }
        catch(SamHolman\Base\Exceptions\TemplateNotFoundException $e) {}

        $this->assertInstanceOf('SamHolman\Site\Article\Entity', $view->article);
        $this->assertEquals('Title', $view->article->getTitle());
    }
}
