<?php

namespace app\widgets;

use Yii;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm as YActiveForm;

class ActiveForm extends YActiveForm
{
    const COLS_TOTAL = 12;

    public $layout = 'horizontal';

    public $labelCols = 2;

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
        $this->fieldConfig['horizontalCssClasses']['label'] = 'col-sm-' . $this->labelCols;
        $this->fieldConfig['horizontalCssClasses']['wrapper'] = 'col-sm-' . (self::COLS_TOTAL - $this->labelCols);

        if (!isset($this->options['class'])) {
            $this->options['class'] = [];
        }
        Html::addCssClass($this->options['class'], 'app-check-changes');

        parent::init();
        
        $params = Yii::$app->request->queryParams;
        if (!empty($params['_return_url'])) {
            echo Html::hiddenInput('_return_url', $params['_return_url']);
        }
    }
}
