<?php

use SamHolman\Base\App,
    SamHolman\Base\Pagination;

class PaginationTest extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $view       = App::make('SamHolman\Base\View');
        $pagination = new Pagination($view);
        $output     = $pagination->get(1, 2);

        $this->assertNotEmpty($output);
        $this->assertEquals(1, $view->currentPage);
        $this->assertEquals(2, $view->totalPages);
    }
}
