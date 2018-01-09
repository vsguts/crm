<?php

namespace app\widgets\form;

use yii\bootstrap\ActiveForm as BActiveForm;
use yii\helpers\Html;

class SearchForm extends BActiveForm
{
    const COLS_TOTAL = 12;

    public $action = ['index'];

    public $method = 'get';

    public $layout = 'horizontal';

    public $labelCols = 3;

    public $fieldConfig = [
        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{endWrapper}",
        'horizontalCssClasses' => [
            'label' => 'col-sm-3',
            'offset' => '',
            'wrapper' => '',
            'error' => '',
            'hint' => '',
        ],
    ];

    public $targetClass;

    protected $extraClass;

    public function init()
    {
        $this->fieldConfig['horizontalCssClasses']['label'] = 'col-sm-' . $this->labelCols;
        $this->fieldConfig['horizontalCssClasses']['wrapper'] = 'col-sm-' . (self::COLS_TOTAL - $this->labelCols);

        parent::init();

        if (!$this->targetClass) {
            $controller = $this->getView()->context;
            $this->targetClass = $controller->id . '_' . $controller->action->id . '_search_form';
            $this->targetClass = preg_replace('/[^a-zA-Z0-9_-]+/Sui', '-', $this->targetClass);
        }

        echo Html::beginTag('div', ['class' => 'panel panel-info search-form']);

        echo Html::tag('div', __('Search'), [
            'class' => 'panel-heading app-toggle app-toggle-save pointer',
            'data-target-class' => $this->targetClass,
        ]);

        $this->extraClass = empty($_COOKIE['app-toggle-' . $this->targetClass]) ? 'h ' : '';
        echo Html::beginTag('div', ['class' => 'panel-body ' . $this->extraClass . $this->targetClass]);
    }

    public function run()
    {
        echo Html::endTag('div');

        $buttons = Html::tag('div',
            Html::submitButton(__('Search'), ['class' => 'btn btn-primary'])
            // .' '. Html::resetButton(__('Reset'), ['class' => 'btn btn-default'])
        );

        echo Html::tag('div', $buttons, ['class' => 'panel-footer ' . $this->extraClass . $this->targetClass]);

        echo Html::endTag('div');

        parent::run();
    }
}