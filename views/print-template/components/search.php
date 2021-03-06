<?php

use yii\helpers\Html;
use app\widgets\form\SearchForm;

?>

<div class="template-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'status')->dropDownList($model->getLookupItems('status', ['empty' => true])) ?>

        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'created_at')->widget('app\widgets\form\DatePickerRange') ?>
            <?= $form->field($model, 'updated_at')->widget('app\widgets\form\DatePickerRange') ?>

        </div>
    </div>

    <?php SearchForm::end(); ?>

</div>
