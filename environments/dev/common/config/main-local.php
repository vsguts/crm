<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=crm',
            'username' => 'gvs',
            'password' => 'gvs',
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

        'mailer' => [
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],

        'htmlToPdf' => [
            'options' => [
                'dpi' => 380, // Mac workaround
            ]
        ],
    ],
];
