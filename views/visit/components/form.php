<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
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
        'label' => __('Images'),
        'content' => $this->render('form_images', ['form' => $form, 'model' => $model]),
    ],
];

echo Tabs::widget([
    'options' => [
        'id' => 'partner_tabs',
        'class' => 'm-tabs-save'
    ],
    'items' => $tab_items,
]);

echo ButtonsContatiner::widget(['model' => $model]);

ActiveForm::end();

