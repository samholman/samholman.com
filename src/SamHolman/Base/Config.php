<?php namespace SamHolman\Base;

class Config
{
    private static
        $_instance;

    private
        $_settings = [];

    /**
     * Force singleton
     */
    private function __construct() {}

    /**
     * Returns a config setting
     *
     * @param string $config
     * @return mixed|null
     */
    public static function get($config)
    {
        return isset(self::getInstance()->_settings[$config]) ? self::getInstance()->_settings[$config] : null;
    }

    /**
     * Return an instance of this config
     *
     * @return Config
     */
    public static function getInstance()
    {
        self::init();
        return self::$_instance;
    }

    /**
     * Initialise an instance
     *
     * @return void
     */
    public static function init()
    {
        if (!self::$_instance) {
            self::$_instance = new Config();
            self::$_instance->_settings = include_once __DIR__ . '/../../../config/settings.php';
        }
    }
}
