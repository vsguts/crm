<?php
return [
    'components' => [
        'urlManager' => [
            'hostInfo' => 'https://finance.example.com',
            'baseUrl' => '',
        ],
    ],
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'bootstrap' => ['gii'],
];
