<?php namespace SamHolman\Site\Controllers;

use \SamHolman\Base\Input,
    \SamHolman\Base\Http\Response,
    \SamHolman\Base\View,
    \SamHolman\Base\Pagination,
    \SamHolman\Base\Config,
    \SamHolman\Site\Article\Service as ArticleService;

class Blog
{
    private
        $_config,
        $_input,
        $_response,
        $_view,
        $_pagination,
        $_service;

    public function __construct(Config $config, Input $input, Response $response, View $view, Pagination $pagination, ArticleService $service)
    {
        $this->_config     = $config;
        $this->_input      = $input;
        $this->_response   = $response;
        $this->_view       = $view;
        $this->_pagination = $pagination;
        $this->_service    = $service;
    }

    /**
     * View article index
     *
     * @return string
     */
    public function index()
    {
        $page  = (int)$this->_input->get('page') ?: 1;
        $limit = $this->_config->get('pagination_limit') ?: 1;

        return $this->_view->make(
            'pages/article/list', [
                'articles'   => $this->_service->getArticles(($page-1)*$limit, $limit),
                'pagination' => $this->_pagination->get($page, ceil($this->_service->getArticleCount() / $limit)),
            ]
        );
    }

    /**
     * View an article
     *
     * @param string $article
     * @return string
     */
    public function article($article)
    {
        if (!$article = $this->_service->getArticle($article)) {
            $this->_response->header('HTTP/1.0 404 Not Found');
            return $this->_view->make('errors/404');
        }

        return $this->_view->make(
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
        );
    }
}
