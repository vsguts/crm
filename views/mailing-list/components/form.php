<?php

use app\widgets\form\ActiveForm;
use yii\bootstrap\Tabs;

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
                'form' => $form,
                'model' => $model,
            ]),
            'active' => true,
        ],
        [
            'label' => __('Subscribers'),
            'content' => $this->render('form_subscribers', [
                'form' => $form,
                'model' => $model,
            ]),
        ],
    ],
]);

ActiveForm::end();
