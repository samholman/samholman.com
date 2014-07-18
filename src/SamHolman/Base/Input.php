<?php namespace SamHolman\Base;

class Input
{
    private static
        $_rawInput;

    /**
     * Returns the request path
     *
     * @return string
     */
    public function getRequestPath()
    {
        $parts = parse_url(!empty($_SERVER['REQUEST_URI']) ? 'http://example.org' . $_SERVER['REQUEST_URI'] : false);
        return !empty($parts['path']) ? $parts['path'] : null;
    }

    /**
     * Returns the request method
     *
     * @return string
     */
    public function getRequestMethod()
    {
        return isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : 'get';
    }

    /**
     * Returns data from get
     *
     * @param string $var
     * @return mixed
     */
    public function get($var=null)
    {
        if ($var) {
            return isset($_GET[$var]) ? $_GET[$var] : null;
        }

        return $_GET;
    }

    /**
     * Returns data from post
     *
     * @param string $var
     * @return mixed
     */
    public function post($var=null)
    {
        if ($var) {
            return isset($_POST[$var]) ? $_POST[$var] : null;
        }

        return $_POST;
    }

    /**
     * Returns raw input from php://input
     *
     * @return string
     */
    public function raw()
    {
        if (self::$_rawInput === null) {
            self::$_rawInput = file_get_contents('php://input');
        }

        return self::$_rawInput;
    }

    /**
     * Returns a decoded json object from raw input
     *
     * @return mixed
     */
    public function json()
    {
        return json_decode($this->raw());
    }
}
