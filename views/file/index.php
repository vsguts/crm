<?php

use yii\web\JsExpression;
use mihaildev\elfinder\ElFinder;

$this->title = __('Files');

echo ElFinder::widget([
    'language'         => 'ru',
    'controller'       => 'elfinder',
    'filter'           => 'image',
    'containerOptions' => [
        'style' => 'height: 800px',
    ],
]);

