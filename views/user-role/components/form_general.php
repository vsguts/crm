<?php

use app\models\AuthItem;

/**
 * @var AuthItem $model
 * @var \app\widgets\form\ActiveForm $form
 */

echo $form->field($model, 'description')->textInput([
    'id' => $form_id . '-description',
]);

if ($model->isNewRecord || $model->status != AuthItem::STATUS_SYSTEM) {
    echo $form->field($model, 'name')->textInput([
        'id'       => $form_id . '-name',
        'disabled' => true,
    ]);

    echo $form->field($model, 'status')->dropDownList(
        $model->getLookupItems('status', ['skip' => AuthItem::STATUS_SYSTEM]),
        ['id' => $form_id . '-status']
    );

} else {
    echo $form->field($model, 'name')->text();

    echo $form->field($model, 'status')->text(['value' => $model->getLookupItem('status')]);
}

