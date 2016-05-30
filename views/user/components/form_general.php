<?php

echo $form->field($model, 'name')->textInput(['maxlength' => 255]);

echo $form->field($model, 'email')->textInput(['maxlength' => 255]);

echo $form->field($model, 'password')->passwordInput();

echo $form->field($model, 'status')->dropDownList($model->getLookupItems('status'));

echo $form->field($model, 'country_id')->dropDownList($model->getList('Country', 'name', ['empty' => true]), ['class' => 'form-control app-country']);

echo $form->field($model, 'state_id')->dropDownList(['' => ' -- '], ['data-app-value' => $model->state_id]);

echo $form->field($model, 'state')->textInput(['maxlength' => 255]);

echo $form->field($model, 'city')->textInput();

echo $form->field($model, 'address')->textInput(['maxlength' => 255]);

if (!$model->isNewRecord) {
    echo $form->field($model, 'created_at')->widget('app\widgets\Text', ['formatter' => 'date']);
    echo $form->field($model, 'updated_at')->widget('app\widgets\Text', ['formatter' => 'date']);
}
