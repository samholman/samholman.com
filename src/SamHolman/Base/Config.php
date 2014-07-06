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
        return self::init();
    }

    /**
     * Initialise an instance
     *
     * @param string $settingsFile
     * @return void
     */
    public static function init($settingsFile=null)
    {
        if (!self::$_instance || $settingsFile) {
            self::$_instance = new Config();

            if ($settingsFile) {
                self::$_instance->_settings = include_once $settingsFile;
            }
        }

        return self::$_instance;
    }
}
