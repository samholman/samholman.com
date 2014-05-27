<?php

use \SamHolman\App,
    \SamHolman\Config;

/**
 * Register routes
 */
App::register('/about', 'About');
App::register('regex:/^\/([a-z0-9_\-]*)$/i', 'Index');

/**
 * Interface -> Concrete class bindings for automatic IoC resolution
 */
App::bind(
    'SamHolman\Response',
    function() {
        return App::make('\SamHolman\Http\Response');
    }
);

App::bind(
    'SamHolman\Article\Repository',
    function () {
        if (!is_dir(Config::get('content_dir'))) {
            throw new \Exception("The content directory doesn't exist. Check your config.");
        }
        return App::make('\SamHolman\Article\FileRepository', [new \DirectoryIterator(Config::get('content_dir'))]);
    }
);

/**
 * General settings
 */
return [
    'view_dir'    => realpath(__DIR__ . '/../src/SamHolman/Views'),
    'content_dir' => realpath(__DIR__ . '/../content'),
];
