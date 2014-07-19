<?php

use SamHolman\Base\Config;

class ConfigTest extends PHPUnit_Framework_TestCase
{
    public function testInit()
    {
        $this->assertInstanceOf('SamHolman\Base\Config', Config::init());
    }

    public function testGet()
    {
        $settingsFile = tempnam(sys_get_temp_dir(), 'settings_test');
        file_put_contents($settingsFile, "<?php return ['setting' => 'test'];");

        $config = Config::init($settingsFile);
        $this->assertNull($config->get('invalid'));
        $this->assertEquals('test', $config->get('setting'));

        unlink($settingsFile);
    }
}
