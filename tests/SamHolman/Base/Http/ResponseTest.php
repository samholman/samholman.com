<?php

use SamHolman\Base\Http\Response;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testHeader()
    {
        $response = new Response();
        $this->assertNull($response->header('Test'));
        $this->assertCount(1, $response->getHeaders());
    }
}
