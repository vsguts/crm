<?php

use common\widgets\form\ActiveForm;
use common\widgets\form\ButtonsContatiner;
use common\widgets\Modal;

if ($model->isNewRecord) {
    $obj_id = 'country_create';
    $header = __('Create country');
} else {
    $obj_id = 'country_' . $model->id;
    $header = __('Country: {country}', [
        'country' => $model->name,
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

echo $form->field($model, 'name')->textInput(['maxlength' => 255]);

echo $form->field($model, 'code')->textInput(['maxlength' => 255]);

ActiveForm::end();

Modal::end();
