<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

$config = require(__DIR__ . '/../bootstrap/web.php');

(new yii\web\Application($config))->run();
