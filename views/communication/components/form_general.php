<?php

use app\models\User;

/** @var \app\models\Communication $model */

echo $form->field($model, 'timestamp')->widget('app\widgets\form\DatePicker', ['options' => [
    'id' => $form_id . '-timestamp',
]]);

echo $form->field($model, 'partner_id')->widget('app\widgets\form\Select2', [
    'url' => ['partner/list'],
    'initValueText' => $model->partner ? $model->partner->extendedName : '',
    'options' => ['placeholder' => 'Select partner'],
    'relatedUrl' => !$model->isNewRecord ? ['partner/update', 'id' => $model->partner_id] : false,
]);

echo $form->field($model, 'user_id')->dropDownList(User::find()->permission()->scroll(['empty' => true]));

echo $form->field($model, 'type')->dropDownList($model->getLookupItems('type'));

echo $form->field($model, 'notes')->textarea(['rows' => 6]);
