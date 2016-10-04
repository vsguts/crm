<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use app\widgets\ActiveForm;
use app\widgets\ButtonsContatiner;
use app\models\MailingList;

$form = ActiveForm::begin(['id' => 'newsletter_form', 'options' => ['enctype' => 'multipart/form-data']]);

$this->beginBlock('general');

echo $form->field($model, 'subject')->textInput(['maxlength' => true]);

echo $form->field($model, 'body')
    ->hint($this->render('hint_content'))
    // ->textarea(['rows' => 6]);
    ->widget('app\widgets\Wysiwyg');

$widget = $form->field($model, 'attachments')->widget('app\widgets\Attachments');
if ($widget->parts['{input}']) {
    echo $widget;
}

echo $form->field($model, 'attachmentsUpload[main][]')->fileInput(['multiple' => true]);

echo $form->field($model, 'mailingListIds')->checkboxList(MailingList::find()->active()->scroll());

if (!$model->isNewRecord) {
    echo $form->field($model, 'created_at')->widget('app\widgets\Text', ['formatter' => 'date']);
    echo $form->field($model, 'updated_at')->widget('app\widgets\Text', ['formatter' => 'date']);
}

$this->endBlock();

if ($model->isNewRecord) {
    echo $this->blocks['general'];
} else {
    echo Tabs::widget([
        'options' => [
            'id' => 'partner_tabs',
            'class' => 'app-tabs-save'
        ],
        'items' => [
            [
                'label' => __('General'),
                'content' => $this->blocks['general'],
            ],
            [
                'label' => __('Logs'),
                'content' => $this->render('logs', ['dataProvider' => $logSearch, 'model' => $model]),
            ],
        ],
    ]);
}

ActiveForm::end();
