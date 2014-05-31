<?php namespace SamHolman\Site\Controllers;

use \SamHolman\Base\View;

class About extends BaseAbstract
{
    private
        $_view;

    public function __construct(View $view)
    {
        $this->_view = $view;
    }

    public function get()
    {
        return $this->_view->make('pages/about', ['title' => 'About']);
    }
}
