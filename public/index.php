<?php use \SamHolman\Base\App;

require_once '../vendor/autoload.php';

echo App::make('\SamHolman\Base\App')->run()->render();
exit;
