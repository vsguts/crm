<?php

$config = [
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => env('COOKIE_VALIDATION_KEY'),
            'enableCookieValidation' => false,
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'converter' => [
                'class' => 'yii\web\AssetConverter',
            ],
            'appendTimestamp' => true,
            'linkAssets' => env('LINK_ASSETS'),
        ],
        'view' => [
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
    ],
    'modules' => [
        'redactor' => [
            'class' => 'app\modules\RedactorModule',
            'uploadDir' => '@webroot/images/uploads',
            'uploadUrl' => '@web/images/uploads',
            'imageAllowExtensions' => ['jpg', 'png', 'gif'],
        ]
    ],
];

if (YII_ENV_DEV) {
    $localIps = array_merge(
        explode(',', env('LOCAL_IP_ADDRESSES')),
        ['127.0.0.1', '::1']
    );

    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => $localIps,
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => $localIps,
    ];
}


return $config;
