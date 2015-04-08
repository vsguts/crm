<?php

echo $form->field($model, 'country_id')->dropDownList($model->getList('Country', 'name', ['empty' => true]), ['class' => 'form-control m-country']);

echo $form->field($model, 'state_id')->dropDownList(['' => ' -- '], ['data-c-value' => $model->state_id]);

echo $form->field($model, 'state')->textInput(['maxlength' => 255]);

echo $form->field($model, 'city')->textInput();

echo $form->field($model, 'address')->textInput(['maxlength' => 255]);

echo $form->field($model, 'zipcode')->textInput(['maxlength' => 255]);
