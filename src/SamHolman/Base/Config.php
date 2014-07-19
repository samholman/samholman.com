<?php namespace SamHolman\Base;

class Config
{
    private static
        $_instance;

    private
        $_settings = [];

    /**
     * Returns a config setting
     *
     * @param string $config
     * @return mixed|null
     */
    public function get($config)
    {
        return isset(self::init()->_settings[$config]) ? self::init()->_settings[$config] : null;
    }

    /**
     * Returns an instance
     *
     * @param string $settingsFile
     * @return Config
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
