<?php

use yii\helpers\Html;
use app\widgets\SearchForm;

?>

<div class="visit-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'partner_id')->widget('app\widgets\SelectAjax', [
                'initValueText' => $model->partner ? $model->partner->extendedName : '',
            ]); ?>

            <?= $form->field($model, 'sum')->widget('app\widgets\Range') ?>

            <?= $form->field($model, 'notes') ?>

        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'timestamp')->widget('app\widgets\DatePickerRange') ?>

            <?= $form->field($model, 'created_at')->widget('app\widgets\DatePickerRange') ?>

            <?= $form->field($model, 'updated_at')->widget('app\widgets\DatePickerRange') ?>

        </div>
    </div>

    <?php SearchForm::end(); ?>

</div>
