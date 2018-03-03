<?php

use app\models\Partner;
use app\models\TaskPartner;
use app\models\User;
use app\widgets\form\ActiveForm;
use app\widgets\form\ButtonsContatiner;
use app\widgets\Modal;

/** @var \app\models\Task $model */

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
        'saveLink' => Yii::$app->user->can('task_manage'),
        'form' => $form_id,
    ]),
]);

$form = ActiveForm::begin([
    'options' => [
        'id' => $form_id,
    ]
]);

echo $form->field($model, 'name')->textInput();

$items = Partner::find()->permission()->scroll(['field' => 'extendedName', 'empty' => true]);
$currentPartnerIds = TaskPartner::find()
    ->where(['task_id' => $model->id])
    ->ids('partner_id');
echo $form->field($model, 'partners_ids[]')->widget('app\widgets\form\Select2', [
    'multiline'    => true,
    'items'        => $items,
    'currentItems' => array_intersect_key($items, array_flip($currentPartnerIds)),
    'options'      => ['placeholder' => __('Select client')],
    'relatedUrl'   => function ($id) {
        return [
            'href' => Url::to(['partner/update', 'id' => $id]),
        ];
    },
]);

echo $form->field($model, 'user_id')->dropDownList(User::find()->permission()->scroll(['empty' => true]));

echo $form->field($model, 'timestamp')->widget('app\widgets\form\DatePicker', ['options' => [
    'id' => $form_id . '-timestamp',
]]);

echo $form->field($model, 'done')->checkbox(['class' => 'checkboxfix'], false);

echo $form->field($model, 'notes')->textarea(['rows' => 6]);

if (!$model->isNewRecord) {
    echo $form->field($model, 'created_at')->text(['format' => 'date']);

    echo $form->field($model, 'updated_at')->text(['format' => 'date']);
}

ActiveForm::end();

Modal::end();
