<?php
declare(strict_types=1);

use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Helper;

return [
    'dependencies' => [
        'factories' => [
            Helper\ServerUrlMiddleware::class => Helper\ServerUrlMiddlewareFactory::class,
            Helper\UrlHelperMiddleware::class => Helper\UrlHelperMiddlewareFactory::class,
            PSR7Session\Http\SessionMiddleware::class => App\Middleware\SessionMiddlewareFactory::class,
            App\Middleware\FlushingMiddleware::class => App\Middleware\FlushingMiddlewareFactory::class
        ],
    ],
    'middleware_pipeline' => [
        'always' => [
            'middleware' => [
                Helper\ServerUrlMiddleware::class,
            ],
            'priority' => 10000,
        ],
        'routing' => [
            'middleware' => [
                ApplicationFactory::ROUTING_MIDDLEWARE,
                App\Middleware\FlushingMiddleware::class,
                Helper\UrlHelperMiddleware::class,
                PSR7Session\Http\SessionMiddleware::class,
                App\Middleware\AuthenticationMiddleware::class,
                ApplicationFactory::DISPATCH_MIDDLEWARE,
            ],
            'priority' => 1,
        ],
        'error' => [
            'middleware' => [
            ],
            'error'    => true,
            'priority' => -10000,
        ],
    ],
];
