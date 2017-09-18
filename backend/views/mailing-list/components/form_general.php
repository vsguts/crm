<?php

/** @var \common\models\MailingList $model */
/** @var \common\widgets\form\ActiveForm $form */

echo $form->field($model, 'name')->textInput(['maxlength' => true]);
echo $form->field($model, 'from_name')->textInput(['maxlength' => true]);
echo $form->field($model, 'from_email')->textInput(['maxlength' => true]);
echo $form->field($model, 'reply_to')->textInput(['maxlength' => true]);
echo $form->field($model, 'status')->dropDownList($model->getLookupItems('status'));
