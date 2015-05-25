<?php

use yii\web\JsExpression;
use mihaildev\elfinder\ElFinder;

$this->title = __('Files');

echo ElFinder::widget([
    'language'         => 'ru',
    'controller'       => 'elfinder',
    'filter'           => ['image', 'x', 'text', 'application'],
    'containerOptions' => [
        'style' => 'height: 800px',
    ],
]);

