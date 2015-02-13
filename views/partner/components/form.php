<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use kartik\date\DatePicker;
use app\widgets\ActiveForm;
use app\widgets\ButtonsContatiner;


$form = ActiveForm::begin();

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
    
    $tab_items[] = [
        'label' => __('Visits'),
        'content' => $this->render('/visit/components/grid', [
            'dataProvider' => $extra['visitsDataProvider'],
            'partnerId' => $model->id,
        ]),
    ];
    
    $tab_items[] = [
        'label' => __('Donates'),
        'content' => $this->render('/donate/components/grid', [
            'dataProvider' => $extra['donatesDataProvider'],
            'partnerId' => $model->id,
        ]),
    ];
    
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
