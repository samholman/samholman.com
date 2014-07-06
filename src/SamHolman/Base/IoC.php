<?php namespace SamHolman\Base;

class IoC
{
    private static

        /**
         * Holds interface -> concrete class bindings
         *
         * @var array
         */
        $_iocBindings = [];

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

    /**
     * Lightweight IoC resolver.
     * Returns an instance of the given class with missing dependencies injected automatically.
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
                    if ($requiredClass = $requiredParams[$i]->getClass()) {
                        $params[] = IoC::make($requiredClass->getName());
                    }
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
}
