<?php

use \SamHolman\App,
    \SamHolman\Config;

/**
 * Register routes
 */
App::register('/', 'Index');

/**
 * Interface -> Concrete class bindings for automatic IoC resolution
 */
App::bind(
    'SamHolman\Article\Repository',
    function () {
        return App::make(
            '\SamHolman\Article\FileRepository',
            array(new \DirectoryIterator(Config::get('content_dir')))
        );
    }
);

/**
 * General settings
 */
return array(
    'view_dir'    => realpath(__DIR__ . '/../src/SamHolman/Views'),
    'content_dir' => realpath(__DIR__ . '/../content'),
);
