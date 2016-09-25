#!/usr/bin/env php
<?php

// fcgi doesn't have STDIN and STDOUT defined by default
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));

file_exists($constants = __DIR__ . '/../config/constants.php') && include($constants);

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/components/functions.php');

$config = require(__DIR__ . '/config/console_app.php');

$application = new yii\console\Application($config);
$exitCode = $application->run();
exit($exitCode);
