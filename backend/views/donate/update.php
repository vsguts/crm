<?php

use common\widgets\form\ActiveForm;
use common\widgets\form\ButtonsContatiner;
use common\widgets\Modal;
use common\models\User;

/** @var \common\models\Donate $model */

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
    'size' => Modal::SIZE_LARGE,
    'header' => $header,
    'id' => $obj_id,
    'footer' => ButtonsContatiner::widget([
        'model' => $model,
        'footerWrapper' => false,
        'removeLink' => false,
        'saveLink' => Yii::$app->user->can('donate_manage'),
        'form' => $form_id,
    ]),
]);

$form = ActiveForm::begin([
    'options' => [
        'id' => $form_id,
    ]
]);

echo $form->field($model, 'partner_id')->widget('common\widgets\form\Select2', [
    'initValueText' => $model->partner ? $model->partner->extendedName : '',
    'url' => ['partner/list'],
    'relatedUrl' => !$model->isNewRecord ? ['partner/update', 'id' => $model->partner_id] : false,
]);

echo $form->field($model, 'user_id')->dropDownList(User::find()->permission()->scroll(['empty' => true]), [
    'class' => 'form-control app-select2',
]);

echo $form->field($model, 'sum')->textInput(['maxlength' => 19]);

echo $form->field($model, 'timestamp')->widget('common\widgets\form\DatePicker', ['options' => [
    'id' => $form_id . '-timestamp',
]]);

echo $form->field($model, 'notes')->textarea(['rows' => 6]);

if (!$model->isNewRecord) {

    echo $form->field($model, 'created_at')->text(['formatter' => 'date']);

    echo $form->field($model, 'updated_at')->text(['formatter' => 'date']);
}

ActiveForm::end();

Modal::end();
