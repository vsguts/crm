<?php

use app\widgets\ActiveForm;
use app\widgets\ButtonsContatiner;
use app\widgets\Modal;

if ($model->isNewRecord) {
    $obj_id = 'donate_create';
    $header = __('Create donate');
} else {
    $obj_id = 'donate_' . $model->id;
    $header = __('Donate: {donate}', [
        'donate' => $model->id,
    ]);
}

$form_id = $obj_id . '_form';

Modal::begin([
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

echo $form->field($model, 'partner_id')->dropDownList($model->getList('Partner', 'name'));

echo $form->field($model, 'sum')->textInput(['maxlength' => 19]);

echo $form->field($model, 'timestamp')->widget('kartik\date\DatePicker', [
    'options' => [
        'id' => $form_id . '_timestamp',
        'placeholder' => __('Select date'),
    ],
    'pluginOptions' => ['autoclose' => true],
]);

echo $form->field($model, 'notes')->textarea(['rows' => 6]);

if (!$model->isNewRecord) {

    echo $form->field($model, 'created_at')->widget('app\widgets\Text', ['formatter' => 'date']);

    echo $form->field($model, 'updated_at')->widget('app\widgets\Text', ['formatter' => 'date']);
}

ActiveForm::end();

Modal::end();
