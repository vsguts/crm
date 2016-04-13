<?php

use yii\helpers\Html;
use app\widgets\ActiveForm;
use app\widgets\ButtonsContatiner;
use app\widgets\Modal;

if ($model->isNewRecord) {
    $obj_id = 'user-role_create';
    $header = __('Create user role');
} else {
    $obj_id = 'user-role_' . $model->name;
    $header = __('User role: {role}', [
        'role' => $model->description,
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

echo $form->field($model, 'description')->textInput();

echo Html::tag('h4', __('Permissions'));

foreach ($model->getAllPermissions() as $section => $permissions) {
    echo $form->field($model, 'permissions')->checkboxList($permissions, ['unselect' => null])->label($section);
}

echo Html::tag('h4', __('Inherited roles'));

echo $form->field($model, 'roles')->checkboxList($model->getAllRoles(['plain' => true, 'exclude_self' => true]), ['unselect' => null])->label('');

ActiveForm::end();

Modal::end();
