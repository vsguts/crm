<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => [
        'queue',
        'log',
        'appBootstrap'
    ],
    'modules' => [
        'redactor' => [
            'class' => 'common\modules\redactor\Module',
            'uploadDir' => '@webroot/images/uploads',
            'uploadUrl' => '@web/images/uploads',
            'imageAllowExtensions' => ['jpg', 'png', 'gif'],
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-crm',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'crm-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // App
                '<controlletBase:[\w\-]+>ies' => '<controlletBase>y/index',
                '<controller:[\w\-]+>s' => '<controller>/index',
                '<controller:[\w\-]+>/<id:\d+>' => '<controller>/update',
            ],
        ],
        'assetManager' => [
            'converter' => [
                'class' => 'yii\web\AssetConverter',
            ],
            'appendTimestamp' => true,
        ],
        'response' => [
            'formatters' => [
                'pdf' => [
                    'class' => 'boundstate\htmlconverter\PdfResponseFormatter',
                    // Set a filename to download the response as an attachments (instead of displaying in browser)
                    // 'filename' => 'attachment.pdf'
                ],
            ],
        ],

        // Application components
        'appBootstrap' => [
            'class' => 'backend\components\app\Bootstrap',
        ],
    ],
    'params' => $params,
];
