<?php

use yii\helpers\Html;
use app\models\User;
use app\widgets\SearchForm;
use app\widgets\DatePickerRange;

?>

<div class="visit-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'partner_id')->widget('app\widgets\SelectAjax', [
                'initValueText' => $model->partner ? $model->partner->extendedName : '',
            ]); ?>

            <?= $form->field($model, 'user_id')->dropDownList(User::find()->scroll(['empty' => true])) ?>

            <?= $form->field($model, 'notes') ?>

        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'timestamp')->widget(DatePickerRange::className()) ?>

            <?= $form->field($model, 'created_at')->widget(DatePickerRange::className()) ?>

            <?= $form->field($model, 'updated_at')->widget(DatePickerRange::className()) ?>
        
        </div>
    </div>

    <?php SearchForm::end(); ?>

</div>
