<?php

use \SamHolman\Base\App,
    \SamHolman\Base\Config;

/**
 * Register routes
 */
App::register('/about', 'About');
App::register('regex:/^\/([a-z0-9_\-]*)$/i', 'Index');

/**
 * Interface -> Concrete class bindings for automatic IoC resolution
 */
App::bind(
    'SamHolman\Base\Response',
    function() {
        return App::make('\SamHolman\Base\Http\Response');
    }
);

App::bind(
    'SamHolman\Site\Article\Repository',
    function () {
        if (!is_dir(Config::get('content_dir'))) {
            throw new \Exception("The content directory doesn't exist. Check your config.");
        }
        return App::make('\SamHolman\Site\Article\FileRepository', [new \DirectoryIterator(Config::get('content_dir'))]);
    }
);

/**
 * General settings
 */
return [
    'view_dir'         => realpath(__DIR__ . '/../src/SamHolman/Site/Views'),
    'content_dir'      => realpath(__DIR__ . '/../content'),
    'pagination_limit' => 6,
];
