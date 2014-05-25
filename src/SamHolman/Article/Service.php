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
     * Return all existing articles
     *
     * @return mixed
     */
    public function findAll()
    {
        return $this->_repo->findAll();
    }
}
