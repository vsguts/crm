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
        'export/<object:\w+>' => 'export/index',
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

$config['controllerMap']['elfinder'] = [
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
