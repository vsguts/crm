<?php

echo $form->field($model, 'partner_id')->widget('app\widgets\SelectAjax', [
    'initValueText' => $model->partner ? $model->partner->extendedName : '',
    'url' => !$model->isNewRecord ? ['partner/update', 'id' => $model->partner_id] : false,
]);

echo $form->field($model, 'user_id')->dropDownList($model->getList('User', 'fullname', ['empty_field' => 'username']));

echo $form->field($model, 'timestamp')->widget('app\widgets\DatePicker', [
    'form_id' => $form_id,
]);

echo $form->field($model, 'notes')->textarea(['rows' => 6]);

if (!$model->isNewRecord) {
    echo $form->field($model, 'created_at')->widget('app\widgets\Text', ['formatter' => 'date']);

    echo $form->field($model, 'updated_at')->widget('app\widgets\Text', ['formatter' => 'date']);
}
