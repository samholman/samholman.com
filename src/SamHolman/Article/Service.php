<?php namespace SamHolman\Article;

use SamHolman\Article\Repository as ArticleRepository;

class Service
{
    private $_repo;

    public function __construct(ArticleRepository $repo)
    {
        $this->_repo = $repo;
    }

    /**
     * Returns all articles
     *
     * @return \Generator
     */
    public function getArticles()
    {
        return $this->_repo->findAll();
    }

    /**
     * Returns an article object
     *
     * @param string $slug
     * @return object
     */
    public function getArticle($slug)
    {
        return $this->_repo->find($slug);
    }
}
