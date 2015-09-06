<?php

use app\widgets\ActiveForm;
use app\widgets\ButtonsContatiner;
use app\widgets\Modal;

if ($model->isNewRecord) {
    $obj_id = 'task_create';
    $header = __('Create task');
} else {
    $obj_id = 'task_' . $model->id;
    $header = __('Task: {task}', [
        'task' => $model->id,
    ]);
}

$form_id = $obj_id . '_form';

Modal::begin([
    'size' => Modal::SIZE_LARGE,
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

echo $form->field($model, 'name')->textInput();

echo $form->field($model, 'partners_ids[]')->widget('app\widgets\SelectAjax', [
    'multiple' => true,
    'initObject' => $model->select_partner,
]);

echo $form->field($model, 'user_id')->dropDownList($model->getList('User', 'fullname', ['empty_field' => 'username']));

echo $form->field($model, 'timestamp')->widget('app\widgets\DatePicker', [
    'form_id' => $form_id,
]);

echo $form->field($model, 'done')->checkbox(['class' => 'checkboxfix'], false);

echo $form->field($model, 'notes')->textarea(['rows' => 6]);

if (!$model->isNewRecord) {
    echo $form->field($model, 'created_at')->widget('app\widgets\Text', ['formatter' => 'date']);

    echo $form->field($model, 'updated_at')->widget('app\widgets\Text', ['formatter' => 'date']);
}

ActiveForm::end();

Modal::end();
