<?php

use yii\helpers\Html;

echo $form->field($model, 'mailSendMethod')->dropDownList($model->getLookupItems('mailSendMethod'), [
    'class' => 'm-dtoggle m-dtoggle-method form-control'
]);

$smtpFields = [
    $form->field($model, 'smtpHost'),
    $form->field($model, 'smtpUsername'),
    $form->field($model, 'smtpPassword')->passwordInput(),
    $form->field($model, 'smtpEncrypt')->dropDownList($model->getLookupItems('smtpEncrypt')),
];

echo Html::tag('div', implode(' ', $smtpFields), [
    'class' => 'm-dtoggle-method-smtp' . ($model->mailSendMethod != 'smtp' ? ' h' : '')
]);
