<?php namespace SamHolman\Base;

use SamHolman\Base\Exceptions\PageNotFoundException;

class Router
{
    private static

        /**
         * Holds URI routes
         *
         * @var array
         */
        $_routes = [];

    /**
     * Routes to the given controller
     *
     * @param string $requestMethod
     * @param string $path
     * @return string
     * @throws Exceptions\PageNotFoundException
     */
    public function route($requestMethod, $path)
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

        $exploded = explode('@', $route);
        list($class, $method) = count($exploded) == 2 ? $exploded : [$route, $requestMethod];

        if (class_exists($class)) {
            return call_user_func_array([IoC::make($class), $method], $matches);
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
