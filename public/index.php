<?php namespace SamHolman;

require_once '../vendor/autoload.php';

echo App::make('\SamHolman\App')->run()->render();
exit;
