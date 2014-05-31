<?php namespace SamHolman\Base;

use SamHolman\Base\Exceptions\PageNotFoundException;

class App
{
    private static

        /**
         * @var array
         */
        $_routes = [],

        /**
         * @var array
         */
        $_iocBindings = [];

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
        Config::init();
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

        $controller = $route ? 'SamHolman\Site\Controllers\\' . $route : null;

        if (class_exists($controller)) {
            $method = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : 'get';
            return call_user_func_array([App::make($controller), $method], $matches);
        }
        else {
            throw new PageNotFoundException();
        }
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

    /**
     * Lightweight IoC resolver.
     * Returns an instance of the given class with missing dependencies (hopefully) injected automatically.
     *
     * @param string $class
     * @param array $params
     * @return object
     */
    public static function make($class, array $params=[])
    {
        try {
            $reflectionMethod = new \ReflectionMethod($class, '__construct');
            $requiredParams = $reflectionMethod->getParameters();

            if (count($requiredParams) != count($params)) {
                for ($i=count($params); $i<count($requiredParams); $i++) {
                    $params[] = App::make($requiredParams[$i]->getClass()->getName());
                }
            }

            $reflectionClass = new \ReflectionClass($class);
            return $reflectionClass->newInstanceArgs($params);
        }
        catch (\ReflectionException $e) {
            $reflectionClass = new \ReflectionClass($class);

            if (!$reflectionClass->isInstantiable()) {
                if (isset(self::$_iocBindings[$class])) {
                    $closure = self::$_iocBindings[$class];
                    return $closure();
                }
            }

            return $reflectionClass->newInstanceWithoutConstructor();
        }
    }

    /**
     * Bind an interface to a concrete class via closure
     *
     * @param string $interface
     * @param \Closure $binding
     */
    public static function bind($interface, \Closure $binding)
    {
        self::$_iocBindings[$interface] = $binding;
    }
}
