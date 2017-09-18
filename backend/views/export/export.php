<?php

use common\widgets\form\ActiveForm;
use common\widgets\Modal;

$form_id = 'export_form';

Modal::begin([
    'size' => Modal::SIZE_LARGE,
    'header' => __('Export'),
    'id' => 'export',
    'footer' => Html::submitButton(__('Export'), ['class' => 'btn btn-success', 'form' => $form_id]),
]);

$form = ActiveForm::begin([
    'options' => [
        'id' => $form_id,
    ]
]);


echo $form->field($model, 'formatter')->dropDownList($formatters, [
    'class' => 'app-dtoggle app-dtoggle-formatter form-control'
]);

$csv_fields = [
    $form->field($model, 'delimiter')->dropDownList($model->availableDelimiters)
];
echo Html::tag('div', implode(' ', $csv_fields), [
    'class' => 'app-dtoggle-formatter-csv h'
]);

echo $form->field($model, 'filename');


ActiveForm::end();

Modal::end();
