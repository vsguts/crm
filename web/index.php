<?php

file_exists($constants = __DIR__ . '/../config/constants.php') && include($constants);

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../components/functions.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();
