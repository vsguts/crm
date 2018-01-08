<?php

$config = [
    'id' => 'app',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'appBootstrap'
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'charset' => 'utf8',

            // Need to set DSN

            // Cache
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 3600,
            'schemaCache' => 'cache',
        ],
        // 'redis' => [
        //     'class' => 'yii\redis\Connection',
        //     'port' => defined('REDIS_PORT') ? REDIS_PORT : 6379,
        // ],
        'cache' => [
            // 'class' => 'yii\redis\Cache',
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'session' => [
            // 'class' => 'yii\redis\Session',
            'class' => 'yii\web\Session',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        'formatter' => [
            'class' => 'app\components\app\Formatter',
            'locale' => 'en_US',
            'defaultTimeZone' => 'Europe/Minsk',
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'dd.MM.yyyy HH:mm',
            'decimalSeparator' => '.',
            'thousandSeparator' => ',',
            'currencyCode' => 'USD',
            'nullDisplay' => '',
        ],
        'security' => [
            'class' => 'app\components\app\Security',
            'derivationIterations' => 10,
        ],
        'authManager' => [
            'class' => 'app\components\rbac\DbManager',
            'defaultRoles' => ['role-guest', 'role-authorized'],
            'cache' => 'cache',
        ],
        'image' => [
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD', //GD or Imagick
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    // 'fileMap' => [
                    //     'app' => 'app.php',
                    //     'app/error' => 'error.php',
                    // ],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // Common
                '<controlletBase:[\w\-]+>ies' => '<controlletBase>y/index',
                '<controller:[\w\-]+>s' => '<controller>/index',
                '<controller:[\w\-]+>/<id:\d+>' => '<controller>/update',
            ],
        ],

        // Libs
        'htmlToPdf' => [
            'class' => 'boundstate\htmlconverter\HtmlToPdfConverter',
            'bin' => '/usr/local/bin/wkhtmltopdf',
            // global wkhtmltopdf command line options (see http://wkhtmltopdf.org/usage/wkhtmltopdf.txt)
            'options' => [
                'print-media-type',
                'disable-smart-shrinking',
                'no-outline',
                'page-size' => 'letter',
                'load-error-handling' => 'ignore',
                'load-media-error-handling' => 'ignore',
                'zoom' => 0.5,
            ],
        ],

        // Application components
        'appBootstrap' => [
            'class' => 'app\components\app\Bootstrap',
        ],
        'calendar' => [
            'class' => 'app\components\app\Calendar',
        ],
        'currency' => [
            'class' => 'app\components\app\Currency',
        ],
    ],
    'timeZone' => 'Europe/Minsk',
];

return $config;
