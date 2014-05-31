<?php

use SamHolman\Site\Article\Entity as Article;

class EntityTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $article = new Article('test-title', new \DateTime(), 'Test Title', 'Test content');

        $this->assertEquals('test-title', $article->getSlug());
        $this->assertEquals('Test Title', $article->getTitle());
        $this->assertEquals('Test content', $article->getContent());
    }
}
