<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=tool.local',
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
            'tablePrefix'=>'tbl_'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
