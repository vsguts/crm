<?php

use common\models\User;
use common\widgets\form\ActiveForm;
use common\widgets\form\ButtonsContatiner;
use common\widgets\Modal;

/** @var \common\models\Task $model */
/** @var \common\models\Partner $partner */

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

if ($model->isNewRecord && $partner) {
    $currentItems = [
        $partner->id => $partner->extendedName,
    ];
} else {
    $currentItems = $model->getPartners()->scroll();
}
echo $form->field($model, 'partners_ids[]')->widget('common\widgets\form\Select2', [
    'multiline' => true,
    'currentItems' => $currentItems,
    'url' => ['partner/list'],
    'relatedUrl' => function($id) {
        return [
            'href' => Url::to(['partner/update', 'id' => $id]),
            'target' => '_blank',
        ];
    }
]);

echo $form->field($model, 'user_id')->dropDownList(User::find()->permission()->scroll(['empty' => true]));

echo $form->field($model, 'timestamp')->widget('common\widgets\form\DatePicker', ['options' => [
    'id' => $form_id . '-timestamp',
]]);

echo $form->field($model, 'done')->checkbox(['class' => 'checkboxfix'], false);

echo $form->field($model, 'notes')->textarea(['rows' => 6]);

if (!$model->isNewRecord) {
    echo $form->field($model, 'created_at')->text(['formatter' => 'date']);

    echo $form->field($model, 'updated_at')->text(['formatter' => 'date']);
}

ActiveForm::end();

Modal::end();
