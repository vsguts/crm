<?php

class_alias('\yii\helpers\Html', 'Html');
class_alias('\yii\helpers\Url', 'Url');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'app',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'appBootstrap'
    ],
    'components' => [
        'cache' => [
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
        'db' => $db,
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        'formatter' => [
            'class' => 'app\components\app\Formatter',
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'dd.MM.yyyy HH:mm',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'USD',
            'nullDisplay' => '',
        ],
        'authManager' => [
            'class' => 'app\components\rbac\DbManager',
            'defaultRoles' => ['guest'],
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
                    // 'basePath' => '@app/messages',
                    // 'sourceLanguage' => 'en-US',
                    // 'fileMap' => [
                    //     'app' => 'app.php',
                    //     'app/error' => 'error.php',
                    // ],
                ],
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
    'params' => $params,
    'timeZone' => 'Europe/Minsk',
];

return $config;
