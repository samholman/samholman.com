<?php namespace SamHolman\Site\Controllers;

use \SamHolman\Base\Input,
    \SamHolman\Base\Response,
    \SamHolman\Base\View,
    \SamHolman\Base\Pagination,
    \SamHolman\Base\Config,
    \SamHolman\Site\Article\Service as ArticleService;

class Index extends BaseAbstract
{
    private
        $_input,
        $_response,
        $_view,
        $_pagination,
        $_service;

    public function __construct(Input $input, Response $response, View $view, Pagination $pagination, ArticleService $service)
    {
        $this->_input      = $input;
        $this->_response   = $response;
        $this->_view       = $view;
        $this->_pagination = $pagination;
        $this->_service    = $service;
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

        $page  = (int)$this->_input->get('page') ?: 1;
        $limit = Config::get('pagination_limit') ?: 1;

        return $article ?
            $this->_view->make(
                'pages/article/view', [
                    'article'     => $article,
                    'title'       => $article->getTitle(),
                    'description' =>
                        preg_match('/^.{1,155}\b/s', $article->getContent(), $matches) ?
                            trim(
                                preg_replace(['/[\r\n]+/', '/[^\da-z:,\'\/\(\)\. ]/i'], [' ', ''], $matches[0])
                            ) . '...' :
                            null,
                ]
            ) :
            $this->_view->make(
                'pages/article/list', [
                    'articles'   => $this->_service->getArticles(($page-1)*$limit, $limit),
                    'pagination' => $this->_pagination->get($page, ceil($this->_service->getArticleCount() / $limit)),
                ]
            );
    }
}
