<?php

namespace common\widgets\form;

use yii\redactor\widgets\Redactor;

class Wysiwyg extends Redactor
{
    public $clientOptions = [
        'plugins' => [
            'imagemanager',
            'table',
            'fontcolor',
            'clips',
            'fullscreen',
        ],
    ];

    public function init()
    {
        list($this->clientOptions['lang']) = explode('-', \Yii::$app->language);
        parent::init();
    }

}
