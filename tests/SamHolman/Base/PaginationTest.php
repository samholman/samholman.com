<?php

use SamHolman\Base\IoC,
    SamHolman\Base\Pagination;

class PaginationTest extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $view       = IoC::make('SamHolman\Base\View');
        $pagination = new Pagination($view);
        $output     = $pagination->get(1, 2);

        $this->assertNotEmpty($output);
        $this->assertEquals(1, $view->currentPage);
        $this->assertEquals(2, $view->totalPages);
    }
}
