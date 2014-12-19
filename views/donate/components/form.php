<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\widgets\ButtonsContatiner;
use app\widgets\Text;

/* @var $this yii\web\View */
/* @var $model app\models\Visit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visit-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
    ]); ?>

    <?= $form->field($model, 'partner_id')->dropDownList($model->getList('Partner', 'name')) ?>

    <?= $form->field($model, 'sum')->textInput(['maxlength' => 19]) ?>

    <?= $form->field($model, 'timestamp')->widget('kartik\date\DatePicker', [
        'options' => ['placeholder' => __('Select date')],
        'pluginOptions' => ['autoclose' => true],
    ]) ?>

    <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>

    <?php if (!$model->isNewRecord): ?>
        <?= $form->field($model, 'created_at')->widget(Text::classname(), ['formatter' => 'date']) ?>

        <?= $form->field($model, 'updated_at')->widget(Text::classname(), ['formatter' => 'date']) ?>
    <?php endif; ?>

    <?= ButtonsContatiner::widget(['model' => $model]); ?>

    <?php ActiveForm::end(); ?>

</div>