<?php

use yii\helpers\Html;
use app\widgets\ActiveForm;
use app\widgets\ButtonsContatiner;

$form = ActiveForm::begin();

echo $form->field($model, 'subject')->textInput(['maxlength' => true]);

echo $form->field($model, 'body')
    ->widget('app\widgets\Wysiwyg')
    ->hint($this->render('hint_content'));

echo $form->field($model, 'mailingListIds')->checkboxList($model->getList('MailingList', 'name'));

if (!$model->isNewRecord) {
    echo $form->field($model, 'created_at')->widget('app\widgets\Text', ['formatter' => 'date']);

    echo $form->field($model, 'updated_at')->widget('app\widgets\Text', ['formatter' => 'date']);
}

echo ButtonsContatiner::widget(['model' => $model]);

ActiveForm::end();
