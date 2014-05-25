<?php namespace SamHolman\Controllers;

use \SamHolman\Input,
    \SamHolman\View,
    \SamHolman\Article\Service as ArticleService;

class Index extends BaseController
{
    private
        $_input,
        $_view,
        $_service;

    public function __construct(Input $input, View $view, ArticleService $service)
    {
        $this->_input   = $input;
        $this->_view    = $view;
        $this->_service = $service;
    }

    public function get()
    {
        return $this->_view->make('pages/index', array(
            'articles' => $this->_service->findAll()
        ));
    }
}
