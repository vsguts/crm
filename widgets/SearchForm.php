<?php

namespace app\widgets;

use Yii;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

class SearchForm extends ActiveForm
{
    public $action = ['index'];
    
    public $method = 'get';
    
    public $layout = 'horizontal';

    public $fieldConfig = [
        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{endWrapper}",
        'horizontalCssClasses' => [
            'label' => 'col-sm-3',
            'offset' => 'col-sm-offset-4',
            'wrapper' => 'col-sm-9',
            'error' => '',
            'hint' => '',
        ],
    ];

    public $targetClass = 'search_form';

    protected $extraClass;

    public function init()
    {
        parent::init();

        $controller = $this->getView()->context;
        $this->targetClass = $controller->id . '_' . $controller->action->id . '_' . $this->targetClass;

        echo Html::beginTag('div', ['class' => 'panel panel-info search-form']);

        echo Html::tag('div', __('Search'), [
            'class' => 'panel-heading m-toggle m-toggle-save pointer',
            'data-target-class' => $this->targetClass,
        ]);

        $this->extraClass = empty($_COOKIE['m-toggle-' . $this->targetClass]) ? 'h ' : '';
        echo Html::beginTag('div', ['class' => 'panel-body ' . $this->extraClass . $this->targetClass]);
    }

    public function run()
    {
        echo Html::endTag('div');
        
        $buttons = Html::tag('div',
            Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])
            // .' '. Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default'])
        );
        
        echo Html::tag('div', $buttons, ['class' => 'panel-footer ' . $this->extraClass . $this->targetClass]);
        
        echo Html::endTag('div');

        parent::run();
    }
}