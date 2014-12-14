<?php

use yii\helpers\Html;
use app\widgets\SearchForm;
use app\widgets\DatePickerRange;

?>

<div class="visit-search">

    <?php $form = SearchForm::begin(); ?>

    <?= $form->field($model, 'partner_id')->dropDownList($model->getList('Partner', 'name', ['empty' => __('Partner')])) ?>

    <?= $form->field($model, 'sum') ?>

    <?= $form->field($model, 'timestamp')->widget(DatePickerRange::className()) ?>

    <?= $form->field($model, 'created_at')->widget(DatePickerRange::className()) ?>

    <?= $form->field($model, 'updated_at')->widget(DatePickerRange::className()) ?>

    <?= $form->field($model, 'notes') ?>

    <?php SearchForm::end(); ?>

</div>
