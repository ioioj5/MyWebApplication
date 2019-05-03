<?php
return [
    'vendorPath' => dirname (dirname (__DIR__)) . '/vendor',
    'components' => [
        'db'    => [
            'class'       => 'yii\db\Connection',
            'dsn'         => 'mysql:host=localhost;dbname=my.local',
            'username'    => 'root',
            'password'    => '123456',
            'charset'     => 'utf8',
            'tablePrefix' => 'tbl_',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'redis' => [
            'class'    => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port'     => 6379,
            'database' => 0,
        ],
    ],
];
