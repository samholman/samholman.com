<?php namespace SamHolman\Base\Http;

class Response implements \SamHolman\Base\Response
{
    /**
     * Send a HTTP header
     *
     * @param string $header
     * @return void
     */
    public function header($header)
    {
        if (PHP_SAPI != 'cli') {
            header($header);
        }
    }
}
