<?php

use yii\helpers\Html;
// use yii\bootstrap\ActiveForm;
use kartik\widgets\ActiveForm;
use app\widgets\Tags;

/* @var $this yii\web\View */
/* @var $model app\models\Partner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="partner-form">

<?php
    $form = ActiveForm::begin([
        // 'layout' => 'horizontal',
        'type' => ActiveForm::TYPE_HORIZONTAL,
    ]);
?>

    <?= $form->field($model, 'type')->dropDownList($model->getLookupItems('type'), ['class' => 'm-dtoggle m-dtoggle-type form-control']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'country_id')->dropDownList($model->getList('Country', 'name', ['empty' => true]), ['class' => 'form-control m-country']) ?>

    <?= $form->field($model, 'state_id')->dropDownList(['' => ' -- '], ['data-c-value' => $model->state_id]) ?>

    <?= $form->field($model, 'state')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'city')->textInput() ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>

    <div class="m-dtoggle-type-3 h">
        <?= $form->field($model, 'church_id')->dropDownList($model->getList('Partner', 'name', ['scope' => 'churches', 'empty' => true])) ?>

        <?= $form->field($model, 'volunteer')->checkbox(['class' => 'checkboxfix'], false) ?>

        <?= $form->field($model, 'candidate')->checkbox(['class' => 'checkboxfix'], false) ?>
    </div>

    <?= $form->field($model, 'status')->dropDownList($model->getLookupItems('status')) ?>

    <?= $form->field($model, 'publicTags')->widget(Tags::classname(), []); ?>
    
    <?= $form->field($model, 'personalTags')->widget(Tags::classname(), []); ?>

    <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
