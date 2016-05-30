<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use app\widgets\ActiveForm;
use app\widgets\ButtonsContatiner;

$form = ActiveForm::begin(['id' => 'user_form']);

$general_content = $this->render('form_general', [
    'form' => $form,
    'model' => $model,
]);

if (empty($roles)) {
    echo $general_content;
} else {
    $tab_items = [
        [
            'label' => __('General'),
            'content' => $general_content,
            'active' => true,
        ],
        [
            'label' => __('Roles'),
            'content' => $this->render('form_roles', [
                'form' => $form,
                'model' => $model,
                'roles' => $roles,
            ]),
        ],
    ];

    echo Tabs::widget([
        'options' => [
            'id' => 'user_form_tabs',
            // 'class' => 'app-tabs-save'
        ],
        'items' => $tab_items,
    ]);
}

ActiveForm::end();

