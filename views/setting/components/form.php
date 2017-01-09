<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use app\widgets\ActiveForm;
use app\widgets\ButtonsContatiner;


$form = ActiveForm::begin([
    'id' => 'settings_form',
    'labelCols' => 3,
]);

$tab_items = [
    [
        'label' => __('General'),
        'content' => $this->render('form_general', ['form' => $form, 'model' => $model]),
        'active' => true,
    ],
    [
        'label' => __('E-mails'),
        'content' => $this->render('form_emails', ['form' => $form, 'model' => $model]),
    ],
    [
        'label' => __('Descriptions'),
        'content' => $this->render('form_description', ['form' => $form, 'model' => $model]),
    ],

];

echo Tabs::widget([
    'options' => [
        'id' => 'settings_tabs',
        'class' => 'app-tabs-save'
    ],
    'items' => $tab_items,
]);

ActiveForm::end();
