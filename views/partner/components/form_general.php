<?php

use yii\helpers\Html;

echo $form->field($model, 'type')->dropDownList($model->getLookupItems('type'), [
    'class' => 'm-dtoggle m-dtoggle-type form-control'
]);

$field = $form->field($model, 'name')->textInput(['maxlength' => 64]);
echo Html::tag('div', $field, ['class' => 'm-dtoggle-type-n1 ' . ($model->type == 3 ? 'h' : '')]);

$fields = [
    $form->field($model, 'firstname')->textInput(['maxlength' => 64]),
    $form->field($model, 'lastname')->textInput(['maxlength' => 64]),
];
echo Html::tag('div', implode(' ', $fields), [
    'class' => 'm-dtoggle-type-1 ' . ($model->type != 3 ? 'h' : '')
]);

$field = $form->field($model, 'contact')->textInput(['maxlength' => 128]);
echo Html::tag('div', $field, ['class' => 'm-dtoggle-type-n1 ' . ($model->type == 3 ? 'h' : '')]);

echo $form->field($model, 'email')->textInput(['maxlength' => 64]);
echo $form->field($model, 'phone')->textInput(['maxlength' => 32]);

$fields = [
    $form->field($model, 'parent_id')->widget('app\widgets\SelectAjax', [
        'organizations' => true,
        'initValueText' => $model->parent ? $model->parent->extendedName : '',
    ]),
    $form->field($model, 'volunteer')->checkbox(['class' => 'checkboxfix'], false),

    $form->field($model, 'candidate')->checkbox(['class' => 'checkboxfix'], false),
];
echo Html::tag('div', implode(' ', $fields), [
    'class' => 'm-dtoggle-type-1 ' . ($model->type != 3 ? 'h' : '')
]);

echo $form->field($model, 'status')->dropDownList($model->getLookupItems('status'));

echo $form->field($model, 'publicTags')->widget('app\widgets\Tags', []);

echo $form->field($model, 'personalTags')->widget('app\widgets\Tags', []);

echo $form->field($model, 'notes')->textarea(['rows' => 6]);

if (!$model->isNewRecord) {
    echo $form->field($model, 'created_at')->widget('app\widgets\Text', ['formatter' => 'date']);

    echo $form->field($model, 'updated_at')->widget('app\widgets\Text', ['formatter' => 'date']);
}
