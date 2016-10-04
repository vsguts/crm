<?php

use app\widgets\ActiveForm;
use app\widgets\ButtonsContatiner;
use app\widgets\Modal;
use app\models\Country;

if ($model->isNewRecord) {
    $obj_id = 'state_create';
    $header = __('Create state');
} else {
    $obj_id = 'state_' . $model->id;
    $header = __('State: {state}', [
        'state' => $model->name,
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

echo $form->field($model, 'country_id')->dropDownList(Country::find()->scroll());

echo $form->field($model, 'name')->textInput(['maxlength' => 255]);

echo $form->field($model, 'code')->textInput(['maxlength' => 255]);

ActiveForm::end();

Modal::end();
