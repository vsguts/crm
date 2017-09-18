<?php

class_alias('\yii\bootstrap\Html', 'Html');
class_alias('\common\helpers\Url', 'Url');

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
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

        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 1,
        ],
        'session' => [
            'class' => 'yii\redis\Session',
            'keyPrefix' => 'session:',
            'redis' => [
                'hostname' => 'localhost',
                'port' => 6379,
                'database' => 2,
            ],
        ],
        'cache' => [
            'class' => 'yii\redis\Cache',
            'keyPrefix' => 'cache:',
            'redis' => [
                'hostname' => 'localhost',
                'port' => 6379,
                'database' => 3,
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
        'authManager' => [
            'class' => 'common\components\rbac\DbManager',
            'defaultRoles' => ['role-guest', 'role-authorized'],
            'cache' => 'cache',
            'cacheKey' => 'backendRbac',
        ],
        'queue' => [
            'class' => 'yii\queue\redis\Queue',
            'redis' => 'redis',
            'channel' => 'queue',
        ],
        // // Development:
        // 'queue' => [
        //     'class' => 'yii\queue\sync\Queue',
        //     'handle' => true,
        // ],
        'formatter' => [
            'class' => 'common\components\app\Formatter',
            'locale' => 'en_US',
            'defaultTimeZone' => 'Europe/Kiev',
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'dd.MM.yyyy HH:mm',
            'timeFormat' => 'HH:mm:ss',
            'decimalSeparator' => '.',
            'thousandSeparator' => ',',
            'currencyCode' => 'USD',
            'nullDisplay' => '',
        ],
        'security' => [
            'class' => 'common\components\app\Security',
            'derivationIterations' => 10,
        ],
        // TODO: Move to monolog
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'monolog' => [
            'class' => 'Mero\Monolog\MonologComponent',
            'channels' => [
                'main' => [
                    'handler' => [
                        [
                            'type' => 'rotating_file',
                            'path' => '@runtime/logs/main.log',
                            'level' => 'debug'
                        ]
                    ],
                ],
            ],
        ],
        'view' => [
            'defaultExtension' => 'twig',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    // Array of twig options:Add a comment to this line
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'Html' => ['class' => '\yii\helpers\Html'],
                        'Url' => ['class' => '\common\helpers\Url'],
                        'ViewHelper' => ['class' => '\common\helpers\ViewHelper'],
                    ],
                    'functions' => [
                        '__' => '__',
                        'pd' => 'pd',
                        'p' => 'p',
                    ],
                    'filters' => [
                        'floatval' => 'floatval',
                        'nl2br' => 'nl2br',
                    ],
                    // 'uses' => ['yii\bootstrap'],
                ],
            ],
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
        'image' => [
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD', //GD or Imagick
        ],

        // Application components
        'appBootstrap' => [
            'class' => 'common\components\app\Bootstrap',
        ],
    ],

    'timeZone' => 'Europe/Kiev',

];
