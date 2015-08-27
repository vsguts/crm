<?php

use yii\helpers\Html;
use app\widgets\SearchForm;
use app\widgets\DatePickerRange;

?>

<div class="newsletter-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'subject') ?>
            <?= $form->field($model, 'body') ?>

        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'created_at')->widget(DatePickerRange::className()) ?>
            <?= $form->field($model, 'updated_at')->widget(DatePickerRange::className()) ?>

        </div>
    </div>

    <?php SearchForm::end(); ?>
    
</div>
