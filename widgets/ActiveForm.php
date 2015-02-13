<?php

namespace app\widgets;

use Yii;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm as YActiveForm;

class ActiveForm extends YActiveForm
{
    public $layout = 'horizontal';

    public $fieldConfig = [
        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
            'label' => 'col-sm-2',
            'offset' => 'col-sm-offset-4',
            'wrapper' => 'col-sm-10',
            'error' => '',
            'hint' => '',
        ],
    ];

    public function init()
    {
        parent::init();
        
        $params = Yii::$app->request->queryParams;
        if (!empty($params['_return_url'])) {
            echo Html::hiddenInput('_return_url', $params['_return_url']);
        }
    }
}
