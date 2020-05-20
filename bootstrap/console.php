<?php

require(__DIR__ . '/common.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../config/common.php'),
    require(__DIR__ . '/../config/console.php')
);

$config['params'] = array_merge(
    require(__DIR__ . '/../config/params.php')
);

return $config;
