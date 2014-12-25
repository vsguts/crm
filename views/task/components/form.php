<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\widgets\ButtonsContatiner;

/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
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
    ]); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'partner_id')->dropDownList($model->getList('Partner', 'name')) ?>

    <?= $form->field($model, 'user_id')->dropDownList($model->getList('User', 'fullname', ['empty_field' => 'username'])) ?>

    <?= $form->field($model, 'timestamp')->widget('kartik\date\DatePicker', [
        'options' => ['placeholder' => __('Select date')],
        'pluginOptions' => ['autoclose' => true],
    ]) ?>

    <?= $form->field($model, 'done')->checkbox(['class' => 'checkboxfix'], false) ?>

    <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>

    <?php if (!$model->isNewRecord): ?>
        <?= $form->field($model, 'created_at')->widget('app\widgets\Text', ['formatter' => 'date']) ?>

        <?= $form->field($model, 'updated_at')->widget('app\widgets\Text', ['formatter' => 'date']) ?>
    <?php endif; ?>

    <?= ButtonsContatiner::widget(['model' => $model]); ?>

    <?php ActiveForm::end(); ?>

</div>