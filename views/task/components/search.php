<?php

use yii\helpers\Html;
use app\models\Partner;
use app\widgets\SearchForm;
use app\widgets\DatePickerRange;

?>

<div class="task-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            
            <?= $form->field($model, 'name') ?>

            <?= $form->field($model, 'partner_id')->widget('app\widgets\SelectAjax', [
                'initValueText' => $model->partner_id ? Partner::findOne($model->partner_id)->extendedName : '',
            ]); ?>

            <?= $form->field($model, 'user_id')->dropDownList($model->getList('User', 'name', ['empty' => __('User'), 'empty_field' => 'email'])) ?>
            
            <?= $form->field($model, 'done')->dropDownList([
                '' => ' - ' . __('Done') . ' - ',
                1 => __('Yes'),
                0 => __('No'),
            ]) ?>

        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'timestamp')->widget(DatePickerRange::className()) ?>

            <?= $form->field($model, 'created_at')->widget(DatePickerRange::className()) ?>

            <?= $form->field($model, 'updated_at')->widget(DatePickerRange::className()) ?>

            <?= $form->field($model, 'notes') ?>
        
        </div>
    </div>

    <?php SearchForm::end(); ?>

</div>
