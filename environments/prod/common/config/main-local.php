<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=crm',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],

        // 'redis' => [
        //     'database' => 4,
        // ],
        // 'session' => [
        //     'redis' => [
        //         'database' => 5,
        //     ],
        // ],
        // 'cache' => [
        //     'redis' => [
        //         'database' => 6,
        //     ],
        // ],
    ],
];
