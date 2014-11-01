<?php

$config = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=wycliffe_crm',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];

if (file_exists(__DIR__ . '/db_local.php')) {
    $_config = require(__DIR__ . '/db_local.php');
    $config = array_merge($config, $_config);
}

return $config;
