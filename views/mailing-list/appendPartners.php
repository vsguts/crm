<?php

use yii\helpers\Html;
use app\widgets\ActiveForm;
use app\widgets\Modal;

$this->title = Yii::t('app', 'Add to mailing list');

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
        'class' => 'app-ajax',
        'data-c-modal' => 'append_partners',
    ],
]);

echo $form->field($model, 'partner_ids', ['template' => '{input}'])->hiddenInput();
echo $form->field($model, 'mailing_list_id')->dropDownList($model->getList('MailingList', 'name', ['scope' => 'active']));

ActiveForm::end();

Modal::end();
