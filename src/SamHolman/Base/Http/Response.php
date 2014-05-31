<?php namespace SamHolman\Base\Http;

class Response implements \SamHolman\Base\Response
{
    /**
     * Send a HTTP header
     *
     * @param string $header
     */
    public function header($header)
    {
        header('HTTP/1.0 404 Not Found');
    }
}
