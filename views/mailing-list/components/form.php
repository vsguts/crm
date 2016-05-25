<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use app\widgets\ActiveForm;
use app\widgets\ButtonsContatiner;

$form = ActiveForm::begin(['id' => 'mailing_list_form']);

$this->beginBlock('general');

    echo $form->field($model, 'name')->textInput(['maxlength' => true]);
    echo $form->field($model, 'from_name')->textInput(['maxlength' => true]);
    echo $form->field($model, 'from_email')->textInput(['maxlength' => true]);
    echo $form->field($model, 'reply_to')->textInput(['maxlength' => true]);
    echo $form->field($model, 'status')->dropDownList($model->getLookupItems('status'));

$this->endBlock();

$this->beginBlock('subscribers');

    echo $form->field($model, 'partners_ids[]')->widget('app\widgets\SelectAjax', [
        'multiple' => true,
        'modelField' => 'extendedName',
        'url' => ['partner/update']
    ]);

$this->endBlock();

$tab_items = [
    [
        'label' => __('General'),
        'content' => $this->blocks['general'],
        'active' => true,
    ],
    [
        'label' => __('Subscribers'),
        'content' => $this->blocks['subscribers'],
    ],
];
echo Tabs::widget([
    'options' => [
        'id' => 'partner_tabs',
        // 'class' => 'app-tabs-save'
    ],
    'items' => $tab_items,
]);

ActiveForm::end();
