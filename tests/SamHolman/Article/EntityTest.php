<?php

use SamHolman\Article\Entity as Article;

class EntityTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $article = new Article('Test title', 'Test content');
        $this->assertEquals('Test Title', $article->getTitle());
        $this->assertEquals('Test content', $article->getContent());
    }
}
