<?php

use common\models\Country;

echo $form->field($model, 'name')->textInput([
    'id' => $form_id . '-name',
    'maxlength' => true,
]);

echo $form->field($model, 'email')->textInput([
    'id' => $form_id . '-email',
    'maxlength' => true,
]);

echo $form->field($model, 'password')->passwordInput([
    'id' => $form_id . '-password',
]);

echo $form->field($model, 'status')->dropDownList($model->getLookupItems('status'), [
    'id' => $form_id . '-status',
]);

echo $form->field($model, 'country_id')->dropDownList(Country::find()->scroll(['empty' => true]), [
    'class' => 'form-control app-country',
    'id' => $form_id . '-country_id',
]);

echo $form->field($model, 'state_id')->dropDownList(['' => ' -- '], [
    'data-app-value' => $model->state_id,
    'id' => $form_id . '-state_id',
]);

echo $form->field($model, 'state')->textInput([
    'id' => $form_id . '-state',
    'maxlength' => true,
]);

echo $form->field($model, 'city')->textInput([
    'id' => $form_id . '-city',
    'maxlength' => true,
]);

echo $form->field($model, 'address')->textInput([
    'id' => $form_id . '-address',
    'maxlength' => true,
]);

if (!$model->isNewRecord) {
    echo $form->field($model, 'created_at')->text(['formatter' => 'date']);
    echo $form->field($model, 'updated_at')->text(['formatter' => 'date']);
}
