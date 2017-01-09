<?php

use yii\bootstrap\Tabs;
use app\widgets\ActiveForm;

$form = ActiveForm::begin(['id' => $form_id]);

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
];

if ($roles) {
    $tab_items[] = [
        'label' => __('Roles'),
        'content' => $this->render('form_roles', [
            'form' => $form,
            'model' => $model,
            'roles' => $roles,
            'form_id' => $form_id,
        ]),
    ];
}

echo Tabs::widget([
    'options' => [
        'id' => $form_id . '_tabs',
        // 'class' => 'app-tabs-save',
    ],
    'items' => $tab_items,
]);

ActiveForm::end();
