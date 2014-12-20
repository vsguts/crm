<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\widgets\ButtonsContatiner;
use app\widgets\Text;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

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

    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
    
    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'role')->dropDownList($model->getLookupItems('role')) ?>

    <?= $form->field($model, 'status')->dropDownList($model->getLookupItems('status')) ?>

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'country_id')->dropDownList($model->getList('Country', 'name', ['empty' => true]), ['class' => 'form-control m-country']) ?>

    <?= $form->field($model, 'state_id')->dropDownList(['' => ' -- '], ['data-c-value' => $model->state_id]) ?>

    <?= $form->field($model, 'state')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'city')->textInput() ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>

    <?php if (!$model->isNewRecord): ?>
        <?= $form->field($model, 'created_at')->widget(Text::classname(), ['formatter' => 'date']) ?>

        <?= $form->field($model, 'updated_at')->widget(Text::classname(), ['formatter' => 'date']) ?>
    <?php endif; ?>

    <?= ButtonsContatiner::widget(['model' => $model]); ?>

    <?php ActiveForm::end(); ?>

</div>
