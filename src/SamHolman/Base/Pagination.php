<?php namespace SamHolman\Base;

class Pagination
{
    private
        $_view;

    public function __construct(View $view)
    {
        $this->_view = $view;
    }

    /**
     * Returns pagination link html
     *
     * @param int $currentPage
     * @param int $totalPages
     * @return string
     */
    public function get($currentPage, $totalPages)
    {
        return $this->_view->make('pagination', [
                'currentPage' => $currentPage,
                'totalPages'  => $totalPages,
            ], __DIR__ . '/Views'
        );
    }
}
