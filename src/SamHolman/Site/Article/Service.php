<?php namespace SamHolman\Site\Article;

use SamHolman\Site\Article\Repository as ArticleRepository;

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
     * @param int $start
     * @param int $limit
     * @return \Generator
     */
    public function getArticles($start, $limit)
    {
        return $this->_repo->findAll($start, $limit);
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

    /**
     * Returns the total number of articles available
     *
     * @return int
     */
    public function getArticleCount()
    {
        return $this->_repo->count();
    }
}
