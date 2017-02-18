<?php

use yii\helpers\Html;
use app\widgets\SearchForm;
use app\models\User;

?>

<div class="communication-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'partner_id')->widget('app\widgets\SelectAjax', [
                'initValueText' => $model->partner ? $model->partner->extendedName : '',
            ]); ?>

            <?= $form->field($model, 'user_id')->dropDownList(User::find()->permission()->scroll(['empty' => true]), [
                'class' => 'form-control app-select2',
            ]) ?>

            <?= $form->field($model, 'notes') ?>

        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'sum')->widget('app\widgets\Range') ?>

            <?= $form->field($model, 'timestamp')->widget('app\widgets\DatePickerRange') ?>

        </div>
    </div>

    <?php SearchForm::end(); ?>

</div>
