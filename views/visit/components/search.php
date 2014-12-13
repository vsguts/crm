<?php

use yii\helpers\Html;
use app\widgets\SearchForm;

?>

<div class="visit-search">

    <?php $form = SearchForm::begin(); ?>

    <?= $form->field($model, 'partner_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'updated_at') ?>

    <?= $form->field($model, 'notes') ?>

    <?php SearchForm::end(); ?>

</div>
