<?php namespace SamHolman\Base\Http;

class Response
{
    private
        $_headers = [];

    /**
     * An an HTTP header to the response
     *
     * @param string $header
     * @return void
     */
    public function header($header)
    {
        $this->_headers[] = $header;
    }

    /**
     * Returns an array of headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->_headers;
    }

    /**
     * Send the headers
     *
     * @return void
     */
    private function sendHeaders()
    {
        array_map('header', $this->_headers);
    }

    public function __destruct()
    {
        $this->sendHeaders();
    }
}
