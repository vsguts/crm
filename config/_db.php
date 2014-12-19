<?php

$config = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=wycliffe_crm',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];

$db_local_file = __DIR__ . '/_db.local.php';
if (file_exists($db_local_file)) {
    $_config = require($db_local_file);
    $config = array_merge($config, $_config);
}

return $config;
