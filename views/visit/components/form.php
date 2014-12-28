<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;
use app\widgets\ButtonsContatiner;

/* @var $this yii\web\View */
/* @var $model app\models\Visit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visit-form">

<?php

    $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'options' => ['enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
                'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-10',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]);

    $tab_items = [
        [
            'label' => __('General'),
            'content' => $this->render('form_general', ['form' => $form, 'model' => $model]),
            'active' => true,
        ],
        [
            'label' => __('Images'),
            'content' => $this->render('form_images', ['form' => $form, 'model' => $model]),
        ],
    ];

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
