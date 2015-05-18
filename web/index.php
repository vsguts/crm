<?php

$pre_index_file = __DIR__ . '/../config/pre_index.php';
if (file_exists($pre_index_file)) {
    include $pre_index_file;
}

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../components/functions.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();
