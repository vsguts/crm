<?php

$config = require(__DIR__ . '/common.php');

$config['components']['log']['traceLevel'] = YII_DEBUG ? 3 : 0;

$config['components']['request'] = [
    'enableCookieValidation' => false,
];

$config['components']['user'] = [
    'identityClass' => 'app\models\User',
    'enableAutoLogin' => true,
];

$config['components']['errorHandler'] = [
    'errorAction' => 'site/error',
];

$config['components']['urlManager'] = [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        // Custom/Fixes
        'countries' => 'country/index',
        // Common
        '<controller:[\w\-]+>s' => '<controller>/index',
        '<controller:[\w\-]+>/<id:\d+>' => '<controller>/update',
    ],
];
$config['components']['view'] = [
    'defaultExtension' => 'twig',
    'renderers' => [
        'twig' => [
            'class' => 'yii\twig\ViewRenderer',
            'cachePath' => '@runtime/Twig/cache',
            // Array of twig options:
            'options' => [
                'auto_reload' => true,
            ],
            'globals' => [
                'html' => '\yii\helpers\Html',
                'url' => '\yii\helpers\Url',
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
];

$config['components']['assetManager'] = [
    'converter' => [
        'class' => 'yii\web\AssetConverter',
    ],
];

$config['components']['response'] = [
    'formatters' => [
        'pdf' => [
            'class' => 'boundstate\htmlconverter\PdfResponseFormatter',
            // Set a filename to download the response as an attachments (instead of displaying in browser)
            'filename' => 'attachment.pdf'
        ],
    ],
];

$config['modules']['redactor'] = [
    'class' => 'app\modules\RedactorModule',
    'uploadDir' => '@webroot/images/uploads',
    'uploadUrl' => '@web/images/uploads',
    'imageAllowExtensions' => ['jpg', 'png', 'gif'],
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
