<?php

use common\models\User;

/** @var \common\models\Communication $model */
/** @var \common\widgets\form\ActiveForm $form */

echo $form->field($model, 'timestamp')->widget('common\widgets\form\DatePicker', ['options' => [
    'id' => $form_id . '-timestamp',
]]);

echo $form->field($model, 'partner_id')->widget('common\widgets\form\Select2', [
    'initValueText' => $model->partner ? $model->partner->extendedName : '',
    'url' => ['partner/list'],
    'relatedUrl' => !$model->isNewRecord ? ['partner/update', 'id' => $model->partner_id] : false,
]);

echo $form->field($model, 'user_id')->dropDownList(User::find()->permission()->scroll(['empty' => true]));

echo $form->field($model, 'type')->dropDownList($model->getLookupItems('type'));

echo $form->field($model, 'notes')->textarea(['rows' => 6]);
