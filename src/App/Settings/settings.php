<?php
return [
    'settings' => [
        'debug' => false,
        'displayErrorDetails' => false, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '\..\..\..\templates',
            'cache' => false
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '\..\..\..\logs\app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],



        //DB CONNECTION SETTINGS
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'grand_bulk_sms',
            'username' => 'grand','port'=>3306,
            'password' => 'password',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ], 
        'db2' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'grand_queue_manager',
            'username' => 'grand','port'=>3306,
            'password' => 'password',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],
        
    ],
];
