<?php

use yii\bootstrap\Tabs;
use app\widgets\form\ActiveForm;
use app\widgets\form\ButtonsContatiner;
use app\widgets\Modal;

if ($model->isNewRecord) {
    $obj_id = 'communication_create';
    $header = __('Create communication');
} else {
    $obj_id = 'communication_' . $model->id;
    $header = __('Bisit: {communication}', [
        'communication' => $model->id,
    ]);
}

$form_id = $obj_id . '_form';

Modal::begin([
    'size' => Modal::SIZE_LARGE,
    'header' => $header,
    'id' => $obj_id,
    'footer' => ButtonsContatiner::widget([
        'model' => $model,
        'footerWrapper' => false,
        'removeLink' => false,
        'saveLink' => Yii::$app->user->can('communication_manage'),
        'form' => $form_id,
    ]),
]);

$form = ActiveForm::begin([
    'options' => [
        'id' => $form_id,
        'enctype' => 'multipart/form-data',
    ]
]);

$tab_items = [
    [
        'label' => __('General'),
        'content' => $this->render('components/form_general', [
            'form' => $form,
            'model' => $model,
            'form_id' => $form_id,
        ]),
        'active' => true,
    ],
    [
        'label' => __('Images'),
        'content' => $this->render('components/form_images', [
            'form' => $form,
            'model' => $model,
            'form_id' => $form_id,
        ]),
    ],
];

echo Tabs::widget([
    'options' => [
        'id' => $form_id . '_tabs',
        // 'class' => 'app-tabs-save'
    ],
    'items' => $tab_items,
]);

ActiveForm::end();

Modal::end();
