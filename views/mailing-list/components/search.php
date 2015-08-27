<?php

use yii\helpers\Html;
use app\widgets\SearchForm;
use app\widgets\DatePickerRange;

?>

<div class="mailing-list-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'from_name') ?>

        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'from_email') ?>
            <?= $form->field($model, 'reply_to') ?>

        </div>
    </div>

    <?php SearchForm::end(); ?>

</div>
