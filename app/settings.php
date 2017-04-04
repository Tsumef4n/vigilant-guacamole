<?php

return [
    'settings' => [
        // Slim Settings
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => false,

        // View settings
        'view' => [
            'template_path' => __DIR__.'/../templates',
            'twig' => [
                'cache' => __DIR__.'/../cache/twig',
                'debug' => false,
                'auto_reload' => true,
            ],
        ],

        // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => __DIR__.'/../log/app.log',
        ],

        'db' => [
          'driver' => 'mysql',
          'host' => 'localhost:3307',
          'database' => 'tsbwshop',
          'username' => 'root',
          'password' => 'usbw',
          'charset' => 'utf8',
          'collation' => 'utf8_unicode_ci',
          'prefix' => '',
        ],
    ],
];
