<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use kartik\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\widgets\ButtonsContatiner;

?>

<div class="partner-form">

<?php
    $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
    ]);

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
            'label' => __('Notes'),
            'content' => $this->render('form_notes', ['form' => $form, 'model' => $model]),
        ],
    ];

    if (!$model->isNewRecord) {
        $tab_items[] = [
            'label' => __('Visits'),
            'content' => $this->render('/visit/components/grid', [
                'dataProvider' => $extra['visitsDataProvider'],
                'partnerId' => $model->id,
            ]),
        ];
        $tab_items[] = [
            'label' => __('Donates'),
            'content' => '',
        ];
        $tab_items[] = [
            'label' => __('Tasks'),
            'content' => '',
        ];
    }

    echo Tabs::widget([
        'options' => [
            'id' => 'partner_tabs',
            'class' => 'm-tabs-save'
        ],
        'items' => $tab_items,
    ]);
    
    echo ButtonsContatiner::widget(['model' => $model]);
    
    ActiveForm::end();
?>

</div>
