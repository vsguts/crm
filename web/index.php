<?php

$config = require(__DIR__ . '/../bootstrap/web.php');

(new yii\web\Application($config))->run();
