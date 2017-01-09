<?php

use yii\helpers\Html;

echo $form->field($model, 'type')->dropDownList($model->getLookupItems('type'), [
    'class' => 'app-dtoggle app-dtoggle-type form-control'
]);

$field = $form->field($model, 'name')->textInput(['maxlength' => 64]);
echo Html::tag('div', $field, ['class' => 'app-dtoggle-type-n1 ' . ($model->type == 3 ? 'h' : '')]);

$fields = [
    $form->field($model, 'firstname')->textInput(['maxlength' => 64]),
    $form->field($model, 'lastname')->textInput(['maxlength' => 64]),
];
echo Html::tag('div', implode(' ', $fields), [
    'class' => 'app-dtoggle-type-1' . ($model->type != 3 ? ' h' : '')
]);

$field = $form->field($model, 'contact')->textInput(['maxlength' => 128]);
echo Html::tag('div', $field, ['class' => 'app-dtoggle-type-n1 ' . ($model->type == 3 ? 'h' : '')]);

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
    'class' => 'app-dtoggle-type-1' . ($model->type != 3 ? ' h' : '')
]);

echo $form->field($model, 'status')->dropDownList($model->getLookupItems('status'));

echo $form->field($model, 'publicTags')->widget('app\widgets\Tags', [
    'readonly' => !Yii::$app->user->can('public_tags_manage'),
]);

echo $form->field($model, 'personalTags')->widget('app\widgets\Tags', []);

echo $form->field($model, 'notes')->textarea(['rows' => 6]);

echo $form->field($model, 'communication_method')->dropDownList($model->getLookupItems('communication_method', ['empty' => true]));


if (!$model->isNewRecord) {
    if ($model->user_id) {
        $user_text = $model->user->name;
        if (Yii::$app->user->can('user_view')) {
            $user_text = Html::a($user_text, null, [
                'href' => Url::to(['user/update', 'id' => $model->user_id, '_return_url' => Url::to()]),
                'class' => 'app-modal',
                'data-target-id' => 'user_' . $model->user_id,
            ]);
        }
        echo $form->field($model, 'user_id')->widget('app\widgets\Text', ['value' => $user_text]);
    }

    echo $form->field($model, 'created_at')->widget('app\widgets\Text', ['formatter' => 'date']);

    echo $form->field($model, 'updated_at')->widget('app\widgets\Text', ['formatter' => 'date']);
}
