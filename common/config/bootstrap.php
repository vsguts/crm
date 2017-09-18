<?php

ini_set('memory_limit', '512M');

$root = dirname(dirname(__DIR__));
Yii::setAlias('@root', $root);
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@api', $root . '/api');
Yii::setAlias('@backend', $root . '/backend');
Yii::setAlias('@console', $root . '/console');
Yii::setAlias('@storage', $root . '/storage');

define('SECONDS_IN_DAY', 24 * 60 * 60);
define('SECONDS_IN_YEAR', SECONDS_IN_DAY * 365);

require(dirname(__DIR__) . '/components/functions.php');
