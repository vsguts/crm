<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests/codeception');

$config = require(__DIR__ . '/common.php');

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
