<?php

use common\widgets\form\ActiveForm;
use yii\bootstrap\Tabs;


$form = ActiveForm::begin(['id' => 'partner_form', 'options' => ['enctype' => 'multipart/form-data']]);

$tab_items = [
    [
        'label' => __('General'),
        'content' => $this->render('form_general', ['form' => $form, 'model' => $model]),
        'active' => true,
    ],
    [
        'label' => __('Address'),
        'content' => $this->render('form_address', ['form' => $form, 'model' => $model]),
    ],
    [
        'label' => __('Images'),
        'content' => $this->render('form_images', ['form' => $form, 'model' => $model]),
    ],
];

if (!$model->isNewRecord) {
    
    $tab_items[] = [
        'label' => __('Communication'),
        'content' => $this->render('/communication/components/grid', [
            'dataProvider' => $extra['communicationsDataProvider'],
            'partnerId' => $model->id,
        ]),
    ];
    
    $tab_items[] = [
        'label' => __('Donates'),
        'content' => $this->render('/donate/components/grid', [
            'dataProvider' => $extra['donatesDataProvider'],
            'partnerId' => $model->id,
        ]),
    ];
    
    $tab_items[] = [
        'label' => __('Tasks'),
        'content' => $this->render('/task/components/grid', [
            'dataProvider' => $extra['tasksDataProvider'],
            'partnerId' => $model->id,
        ]),
    ];
    
    $tab_items[] = [
        'label' => __('Contact persons'),
        'headerOptions' => [
            'class' => 'app-dtoggle-type-n1',
            'style' => ($model->type == 3 ? 'display: none;' : ''),
        ],
        'content' => $this->render('/partner/components/grid', [
            'dataProvider' => $extra['contactsDataProvider'],
            'partnerId' => $model->id,
        ]),
    ];
}

echo Tabs::widget([
    'options' => [
        'id' => 'partner_tabs',
        'class' => 'app-tabs-save'
    ],
    'items' => $tab_items,
]);

// echo ButtonsContatiner::widget(['model' => $model]);

ActiveForm::end();
