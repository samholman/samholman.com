<?php

use SamHolman\Base\IoC,
    SamHolman\Base\Config;

require_once '../vendor/autoload.php';

Config::init(__DIR__ . '/../config/settings.php');
echo IoC::make('\SamHolman\Base\App')->run()->render();
exit;
