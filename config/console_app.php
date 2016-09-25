<?php

$config = require(__DIR__ . '/console.php');

$config['controllerNamespace'] = 'app\commands';

$config['enableCoreCommands'] = false;

return $config;
