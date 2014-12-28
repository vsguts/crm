<?php

use yii\helpers\Html;
use app\widgets\SearchForm;
use app\widgets\DatePickerRange;

?>

<div class="template-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'user_id')->dropDownList($model->getList('User', 'fullname', ['empty' => __('User'), 'empty_field' => 'username'])) ?>

            <?= $form->field($model, 'name') ?>

        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'created_at')->widget(DatePickerRange::className()) ?>

            <?= $form->field($model, 'updated_at')->widget(DatePickerRange::className()) ?>

        </div>
    </div>

    <?php SearchForm::end(); ?>

</div>
