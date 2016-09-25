<?php

$config = require(__DIR__ . '/console.php');

if ($key = array_search('appBootstrap', $config['bootstrap'])) {
    unset($config['bootstrap'][$key]);
}

unset(
    $config['controllerNamespace'],
    $config['components']['appBootstrap']
);

return $config;
