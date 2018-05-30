<?php

return [
    'fetch' => PDO::FETCH_CLASS,
    'default' => 'jeanku',
    'connections' => [
        'jeanku' => [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'port'      => '3306',
            'database'  => 'jeanku',
            'username'  => 'root',
            'password'  => '123456',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
            'engine'    => null,
        ],
    ],

    'rabbitmq' => [
        'host'      => env('RABBITMQ_HOST', '127.0.0.1'),
        'port'      => env('RABBITMQ_PORT', '5672'),
        'login'     => env('RABBITMQ_USERNAME', 'rabbitmq'),
        'password'  => env('RABBITMQ_PASSWORD', '123456'),
        'vhost'     =>'/'
    ],

    'redis' => [
        'default' => [
            'host'      => env('REDIS_HOST', '127.0.0.1'),
            'port'      => env('REDIS_PORT', '6379'),
            'password'  => env('REDIS_PASSWORD', 'redis'),
            'database' => 0,
        ],
        'user' => [
            'host'      => env('REDIS_HOST', '127.0.0.1'),
            'port'      => env('REDIS_PORT', '6379'),
            'password'  => env('REDIS_PASSWORD', 'redis'),
            'database' => 1,
        ],
    ],
];
