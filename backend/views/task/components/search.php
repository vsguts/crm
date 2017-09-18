<?php

use common\models\User;
use common\widgets\form\DatePickerRange;
use common\widgets\form\SearchForm;

/** @var \common\models\search\TaskSearch $model */

?>

<div class="task-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            
            <?= $form->field($model, 'name') ?>

            <?= $form->field($model, 'partner_id')->widget('common\widgets\form\Select2', [
                'url' => ['partner/list'],
                'initValueText' => $model->partner_id ? $model->partner->extendedName : '',
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
