#!/usr/bin/env php
<?php

$config = require(__DIR__ . '/bootstrap/console.php');

$application = new yii\console\Application($config);
$exitCode = $application->run();
exit($exitCode);
