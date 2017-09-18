<?php

use common\models\Country;

echo $form->field($model, 'country_id')->dropDownList(Country::find()->scroll(['empty' => true]), [
    'class' => 'form-control app-country'
]);

echo $form->field($model, 'state_id')->dropDownList(['' => ' -- '], ['data-app-value' => $model->state_id]);

echo $form->field($model, 'state')->textInput(['maxlength' => 64]);

echo $form->field($model, 'city')->textInput(['maxlength' => 64]);

echo $form->field($model, 'address')->textInput(['maxlength' => 255]);

echo $form->field($model, 'zipcode')->textInput(['maxlength' => 16]);
