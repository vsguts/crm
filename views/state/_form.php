<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\widgets\ButtonsContatiner;

/* @var $this yii\web\View */
/* @var $model app\models\State */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="state-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
    ]); ?>

    <?= $form->field($model, 'country_id')->dropDownList($model->getList('Country', 'name')) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 255]) ?>

    <?= ButtonsContatiner::widget(['model' => $model]); ?>

    <?php ActiveForm::end(); ?>

</div>
