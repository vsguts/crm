<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'crm',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'appBootstrap',
    ],
    'language' => 'en-US',
    'sourceLanguage' => 'en-US',
    'params' => $params,

    'components' => [
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
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'hdglamkN-KrsSaNegYbg36nnbz_3Dd_r',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
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
                'load-media-error-handling' => 'ignore'
            ],
        ],
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'dd.MM.yyyy HH:mm',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'USD',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // Custom/Fixes
                'countries' => 'country/index',
                'export/<object:\w+>' => 'export/index',
                // Common
                '<controller:[\w\-]+>s' => '<controller>/index',
                '<controller:[\w\-]+>/<id:\d+>' => '<controller>/update',
            ],
        ],
        'authManager' => [
            'class' => 'app\components\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],
        'assetManager' => [
            'converter' => [
                'class' => 'yii\web\AssetConverter',
            ],
        ],
        'image' => [
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD', //GD or Imagick
        ],
        'response' => [
            'formatters' => [
                'pdf' => [
                    'class' => 'boundstate\htmlconverter\PdfResponseFormatter',
                    // Set a filename to download the response as an attachments (instead of displaying in browser)
                    'filename' => 'attachment.pdf'
                ],
            ],
        ],
        'appBootstrap' => [
            'class' => 'app\components\Bootstrap',
        ],
    ],

    'modules' => [
        'redactor' => [
            'class' => 'app\modules\RedactorModule',
            'uploadDir' => '@webroot/images/uploads',
            'uploadUrl' => '@web/images/uploads',
            'imageAllowExtensions' => ['jpg', 'png', 'gif'],
        ],
    ],

    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['upload_images', 'upload_own_files', 'upload_common_files'],
            'roots' => [
                [
                    'path' => 'files/common',
                    'name' => ['category' => 'app', 'message' => 'Common files'],
                    'access' => ['read' => 'upload_common_files', 'write' => 'upload_common_files']
                ],
                [
                    'class' => 'mihaildev\elfinder\UserPath',
                    'path' => 'files/personal/user_{id}',
                    'name' => ['category' => 'app', 'message' => 'Personal files'],
                    'access' => ['read' => 'upload_own_files', 'write' => 'upload_own_files']
                ],
                [
                    'path' => 'images/uploads',
                    'name' => ['category' => 'app', 'message' => 'Images'],
                    'access' => ['read' => '*', 'write' => 'upload_images']
                ],
            ],
        ]
    ],

];

if (YII_ENV_DEV) { // configuration adjustments for 'dev' environment
    
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '172.17.0.1']
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '172.17.0.1']
    ];
}

return $config;
