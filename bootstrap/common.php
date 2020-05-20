<?php

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/components/functions.php');

$root = dirname(__DIR__);

/**
 * Env vars
 */

$dotenv = \Dotenv\Dotenv::createImmutable($root);
$dotenv->load();

/**
 * Global config
 */

defined('YII_DEBUG') || define('YII_DEBUG', env('YII_DEBUG'));
defined('YII_ENV') || define('YII_ENV', env('YII_ENV'));

ini_set('memory_limit', '512M');

/**
 * Start Yii Base Logic
 */

require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

/**
 * Dirs and base classes config
 */

Yii::setAlias('@root', $root);
Yii::setAlias('@storage', $root . '/storage');

class_alias('\yii\helpers\Html', 'Html');
class_alias('\yii\helpers\Url', 'Url');

/**
 * Constants
 */

define('SECONDS_IN_DAY', 24 * 60 * 60);
define('SECONDS_IN_YEAR', SECONDS_IN_DAY * 365);
