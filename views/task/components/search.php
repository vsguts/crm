<?php

use app\models\Partner;
use app\models\User;
use app\widgets\form\DatePickerRange;
use app\widgets\form\SearchForm;

/** @var \app\models\search\TaskSearch $model */

?>

<div class="task-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            
            <?= $form->field($model, 'name') ?>

            <?= $form->field($model, 'partner_id')->widget('app\widgets\form\Select2', [
                'url' => ['partner/list'],
                'initValueText' => $model->partner_id ? Partner::findOne($model->partner_id)->extendedName : '',
                'options' => ['placeholder' => 'Select partner'],
            ]); ?>

            <?= $form->field($model, 'user_id')->dropDownList(User::find()->permission()->scroll(['empty' => true])) ?>
            
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
