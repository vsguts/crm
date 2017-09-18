<?php

use common\models\User;
use common\widgets\form\SearchForm;

/** @var \common\models\search\DonateSearch $model */

?>

<div class="communication-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'partner_id')->widget('common\widgets\form\Select2', [
                'url' => ['partner/list'],
                'initValueText' => $model->partner ? $model->partner->extendedName : '',
            ]); ?>

            <?= $form->field($model, 'user_id')->dropDownList(User::find()->permission()->scroll(['empty' => true]), [
                'class' => 'form-control app-select2',
            ]) ?>

            <?= $form->field($model, 'notes') ?>

        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'sum')->widget('common\widgets\form\Range') ?>

            <?= $form->field($model, 'timestamp')->widget('common\widgets\form\DatePickerRange') ?>

        </div>
    </div>

    <?php SearchForm::end(); ?>

</div>
