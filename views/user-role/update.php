<?php

use yii\bootstrap\Tabs;
use app\widgets\form\ActiveForm;
use app\widgets\form\ButtonsContatiner;
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
        'saveLink' => Yii::$app->user->can('user_role_manage'),
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
    ],
    'items' => [
        [
            'label' => __('General'),
            'content' => $this->render('components/form_general', [
                'form' => $form,
                'form_id' => $form_id,
                'model' => $model,
            ]),
        ],
        [
            'label' => __('Permissions'),
            'content' => $this->render('components/form_permissions', [
                'form' => $form,
                'form_id' => $form_id,
                'model' => $model,
            ]),
        ],

        // Application
        [
            'label' => __('Objects'),
            'content' => $this->render('components/form_app_objects', [
                'form' => $form,
                'form_id' => $form_id,
                'model' => $model,
            ]),
        ],

        // Inheritance
        [
            'label' => __('Inherited roles'),
            'content' => $this->render('components/form_inherit', [
                'form' => $form,
                'form_id' => $form_id,
                'model' => $model,
            ]),
        ],
    ],
]);


ActiveForm::end();

Modal::end();
