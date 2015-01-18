<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;
use kartik\date\DatePicker;
use app\widgets\ButtonsContatiner;

?>

<div class="partner-form">

<?php
    
    $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'options' => ['enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
                'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-10',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]);

    $tab_items = [
        [
            'label' => __('General'),
            'content' => $this->render('form_general', ['form' => $form, 'model' => $model]),
            'active' => true,
        ],
        [
            'label' => __('Address'),
            'content' => $this->render('form_address', ['form' => $form, 'model' => $model]),
        ],
        [
            'label' => __('Images'),
            'content' => $this->render('form_images', ['form' => $form, 'model' => $model]),
        ],
    ];

    if (!$model->isNewRecord) {
        
        $this->params['override_controller_name'] = 'visit';
        $tab_items[] = [
            'label' => __('Visits'),
            'content' => $this->render('/visit/components/grid', [
                'dataProvider' => $extra['visitsDataProvider'],
                'partnerId' => $model->id,
                'gvsgvs' => 'gvsgvs',
            ]),
        ];
        
        $this->params['override_controller_name'] = 'donate';
        $tab_items[] = [
            'label' => __('Donates'),
            'content' => $this->render('/donate/components/grid', [
                'dataProvider' => $extra['donatesDataProvider'],
                'partnerId' => $model->id,
            ]),
        ];
        
        $this->params['override_controller_name'] = 'task';
        $tab_items[] = [
            'label' => __('Tasks'),
            'content' => $this->render('/task/components/grid', [
                'dataProvider' => $extra['tasksDataProvider'],
                'partnerId' => $model->id,
            ]),
        ];
    }

    echo Tabs::widget([
        'options' => [
            'id' => 'partner_tabs',
            'class' => 'm-tabs-save'
        ],
        'items' => $tab_items,
    ]);
    
    echo ButtonsContatiner::widget(['model' => $model]);
    
    ActiveForm::end();
?>

</div>
