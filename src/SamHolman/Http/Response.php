<?php namespace SamHolman\Http;

class Response implements \SamHolman\Response
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
