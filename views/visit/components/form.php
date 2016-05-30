<?php

use yii\bootstrap\Tabs;
use app\widgets\ActiveForm;
use app\widgets\ButtonsContatiner;
use app\widgets\Modal;

if ($model->isNewRecord) {
    $obj_id = 'visit_create';
    $header = __('Create visit');
} else {
    $obj_id = 'visit_' . $model->id;
    $header = __('Bisit: {visit}', [
        'visit' => $model->id,
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
        'saveLink' => Yii::$app->user->can('visit_manage'),
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
        'content' => $this->render('form_general', [
            'form' => $form,
            'model' => $model,
            'form_id' => $form_id,
        ]),
        'active' => true,
    ],
    [
        'label' => __('Images'),
        'content' => $this->render('form_images', [
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
