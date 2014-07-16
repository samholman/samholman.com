<?php

use SamHolman\Base\Router,
    SamHolman\Base\IoC;

/**
 * General settings
 */
$settings = [
    'view_dir'         => realpath(__DIR__ . '/../src/SamHolman/Site/Views'),
    'content_dir'      => realpath(__DIR__ . '/../content'),
    'pagination_limit' => 6,
];

/**
 * Register routes
 */
Router::register('/about', 'SamHolman\Site\Controllers\About');
Router::register('regex:/^\/([a-z0-9_\-\.]*)$/i', 'SamHolman\Site\Controllers\Index');

/**
 * Interface -> Concrete class bindings for automatic IoC resolution
 */
IoC::bind(
    'SamHolman\Base\Response',
    function() {
        return IoC::make('\SamHolman\Base\Http\Response');
    }
);

IoC::bind(
    'SamHolman\Site\Article\Repository',
    function () use ($settings) {
        if (!is_dir($settings['content_dir'])) {
            throw new \Exception("The content directory doesn't exist. Check your config.");
        }
        return IoC::make('\SamHolman\Site\Article\FileRepository', [new \DirectoryIterator($settings['content_dir'])]);
    }
);

return $settings;
