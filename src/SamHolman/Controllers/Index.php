<?php namespace SamHolman\Controllers;

use \SamHolman\View,
    \SamHolman\Article\Service as ArticleService;

class Index extends BaseAbstract
{
    private
        $_view,
        $_service;

    public function __construct(View $view, ArticleService $service)
    {
        $this->_view    = $view;
        $this->_service = $service;
    }

    /**
     * View articles
     *
     * @param string $article
     * @return string
     */
    public function get($article=null)
    {
        return $article ?
            $this->_view->make(
                'pages/article/view', [
                    'article' => ($article = $this->_service->getArticle($article)),
                    'title' => $article->getTitle()
                ]) :
            $this->_view->make('pages/article/list', ['articles' => $this->_service->getArticles()]);
    }
}
