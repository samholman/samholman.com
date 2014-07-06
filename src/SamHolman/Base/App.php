<?php namespace SamHolman\Base;

use SamHolman\Base\Exceptions\PageNotFoundException;

class App
{
    private static

        /**
         * Holds URI routes
         *
         * @var array
         */
        $_routes = [];

    private

        /**
         * @var Input
         */
        $_input,

        /**
         * @var
         */
        $_output;

    /**
     * @param Input $input
     */
    public function __construct(Input $input)
    {
        $this->_input = $input;
    }

    /**
     * Run the app. :-)
     *
     * @return $this
     */
    public function run()
    {
        $this->_output = $this->route($this->_input->getRequestPath());
        return $this;
    }

    /**
     * Output content
     *
     * @return string
     */
    public function render()
    {
        return $this->_output;
    }

    /**
     * Routes to the given controller
     *
     * @param string $path
     * @return string
     * @throws Exceptions\PageNotFoundException
     */
    private function route($path)
    {
        $matches = [];

        if (!$route = isset(self::$_routes[$path]) ? self::$_routes[$path] : null) {
            foreach (self::$_routes as $key => $destination) {
                if (substr($key, 0, 6) == 'regex:' && preg_match(substr($key, 6), $path, $matches) !== false) {
                    $route = $destination;
                    array_shift($matches);
                    break;
                }
            }
        }

        if (class_exists($route)) {
            $method = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : 'get';
            return call_user_func_array([IoC::make($route), $method], $matches);
        }

        throw new PageNotFoundException();
    }

    /**
     * Register a route
     *
     * @param string $path
     * @param string $controller
     * @return void
     */
    public static function register($path, $controller)
    {
        self::$_routes[$path] = $controller;
    }
}
