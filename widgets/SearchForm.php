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

    public function init()
    {
        parent::init();

        $controller = $this->getView()->context;
        $this->targetClass = $controller->id . '_' . $controller->action->id . '_' . $this->targetClass;

        echo '<div class="panel panel-info">';
        echo ' <div class="panel-heading m-toggle m-toggle-save pointer" data-target-class="' . $this->targetClass . '">';
        echo __('Search');
        echo ' </div>';
        echo ' <div class="panel-body h ' . $this->targetClass . '">';

    }

    public function run()
    {
        echo ' </div>';
        echo ' <div class="panel-footer h ' . $this->targetClass . '">';
        echo '  <div>';
        echo Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']);
        echo ' ';
        echo Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']);
        echo '  </div>';
        echo ' </div>';
        echo '</div>';

        parent::run();
    }
}