<?php

use app\models\User;

echo $form->field($model, 'timestamp')->widget('app\widgets\DatePicker', ['options' => [
    'id' => $form_id . '-timestamp',
]]);

echo $form->field($model, 'partner_id')->widget('app\widgets\SelectAjax', [
    'initValueText' => $model->partner ? $model->partner->extendedName : '',
    'url' => !$model->isNewRecord ? ['partner/update', 'id' => $model->partner_id] : false,
]);

echo $form->field($model, 'user_id')->dropDownList(User::find()->scroll(['empty' => true]));

echo $form->field($model, 'type')->dropDownList($model->getLookupItems('type'));

echo $form->field($model, 'notes')->textarea(['rows' => 6]);
