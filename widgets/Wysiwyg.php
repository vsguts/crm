<?php

namespace app\widgets;

class Wysiwyg extends \yii\redactor\widgets\Redactor
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
