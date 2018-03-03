<?php

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/components/functions.php');

$root = dirname(__DIR__);
Yii::setAlias('@root', $root);
Yii::setAlias('@storage', $root . '/storage');

define('SECONDS_IN_DAY', 24 * 60 * 60);
define('SECONDS_IN_YEAR', SECONDS_IN_DAY * 365);

class_alias('\yii\helpers\Html', 'Html');
class_alias('\yii\helpers\Url', 'Url');

ini_set('memory_limit', '512M');
