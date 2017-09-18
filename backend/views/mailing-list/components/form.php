<?php

use common\widgets\form\ActiveForm;
use yii\bootstrap\Tabs;

/** @var \common\models\MailingList $model */

$form = ActiveForm::begin(['id' => 'mailing_list_form']);

echo Tabs::widget([
    'options' => [
        'id' => 'partner_tabs',
        // 'class' => 'app-tabs-save'
    ],
    'items' => [
        [
            'label' => __('General'),
            'content' => $this->render('form_general', [
                'model' => $model,
                'form' => $form
            ]),
            'active' => true,
        ],
        [
            'label' => __('Subscribers'),
            'content' => $this->render('form_subscribers', [
                'model' => $model,
                'form' => $form
            ]),
        ],
    ],
]);

ActiveForm::end();
