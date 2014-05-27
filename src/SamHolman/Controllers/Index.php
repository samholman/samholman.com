<?php namespace SamHolman\Controllers;

use \SamHolman\Response,
    \SamHolman\View,
    \SamHolman\Article\Service as ArticleService;

class Index extends BaseAbstract
{
    private
        $_response,
        $_view,
        $_service;

    public function __construct(Response $response, View $view, ArticleService $service)
    {
        $this->_response = $response;
        $this->_view     = $view;
        $this->_service  = $service;
    }

    /**
     * View articles
     *
     * @param string $article
     * @return string
     */
    public function get($article=null)
    {
        if ($article && (!$article = $this->_service->getArticle($article))) {
            $this->_response->header('HTTP/1.0 404 Not Found');
            return $this->_view->make('errors/404');
        }

        return $article ?
            $this->_view->make(
                'pages/article/view', [
                    'article' => $article,
                    'title'   => $article->getTitle()
                ]) :
            $this->_view->make('pages/article/list', ['articles' => $this->_service->getArticles()]);
    }
}
