<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use app\widgets\ActiveForm;
use app\widgets\ButtonsContatiner;
use app\widgets\Modal;

if ($model->isNewRecord) {
    $obj_id = 'user-role_create';
    $header = __('Create user role');
} else {
    $obj_id = 'user-role_' . $model->name;
    $header = __('User role: {role}', [
        'role' => $model->description,
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
        'form' => $form_id,
    ]),
]);

$form = ActiveForm::begin([
    'options' => [
        'id' => $form_id,
    ]
]);

echo Tabs::widget([
    'options' => [
        'id' => $form_id . '_tabs',
        'class' => 'app-tabs-save'
    ],
    'items' => [
        [
            'label' => __('General'),
            'content' => $this->render('form_general', [
                'form' => $form,
                'model' => $model,
            ]),
        ],
        [
            'label' => __('Permissions'),
            'content' => $this->render('form_permissions', [
                'form' => $form,
                'model' => $model,
            ]),
        ],
        [
            'label' => __('Inherited roles'),
            'content' => $this->render('form_inherit', [
                'form' => $form,
                'model' => $model,
            ]),
        ],
    ],
]);


ActiveForm::end();

Modal::end();
