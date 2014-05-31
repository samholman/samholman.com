<?php

use SamHolman\Site\Article\Service;

class ServiceTest extends PHPUnit_Framework_TestCase
{
    public function testGetArticles()
    {
        $repo = Mockery::mock('\SamHolman\Site\Article\FileRepository');
        $repo->shouldReceive('findAll')->andReturn(['test']);

        $service = new Service($repo);
        $articles = $service->getArticles();

        $this->assertEquals('test', $articles[0]);
    }

    public function testGetArticle()
    {
        $repo = Mockery::mock('\SamHolman\Site\Article\FileRepository');
        $repo->shouldReceive('find')->andReturn('test');

        $service = new Service($repo);
        $this->assertEquals('test', $service->getArticle('test-slug'));
    }

    public function testGetArticleCount()
    {
        $repo = Mockery::mock('\SamHolman\Site\Article\FileRepository');
        $repo->shouldReceive('count')->andReturn(1);

        $service = new Service($repo);
        $this->assertEquals(1, $service->getArticleCount());
    }
}
