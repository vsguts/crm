<?php

return [
    'components' => [
        'user' => [
            'class' => 'app\components\app\ConsoleUser',
        ],
    ],
    'controllerNamespace' => 'app\commands',
    'bootstrap' => [
        'log',
        'appBootstrap',
    ],
];
