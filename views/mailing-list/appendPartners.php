<?php

use yii\helpers\Html;
use app\widgets\form\ActiveForm;
use app\widgets\Modal;
use app\models\MailingList;

$this->title = __('Add to mailing list');

Modal::begin([
    'size' => Modal::SIZE_LARGE,
    'header' => __('Add to mailing list'),
    'id' => 'append_partners',
    'footer' => Html::submitButton(__('Append'), [
        'class' => 'btn btn-success',
        'form' => 'append_partners_form',
    ]),
]);


$form = ActiveForm::begin(['id' => 'append_partners_form', 
    'action' => ['mailing-list/append-partners'],
    'options' => [
        'class' => ['app-ajax'],
        'data-app-modal' => 'append_partners'
    ],
]);

echo $form->field($model, 'partner_ids', ['template' => '{input}'])->hiddenInput();
echo $form->field($model, 'mailing_list_id')->dropDownList(MailingList::find()->active()->scroll());

ActiveForm::end();

Modal::end();
