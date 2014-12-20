<?php

use yii\helpers\Html;
use app\widgets\SearchForm;

?>

<div class="user-search">

    <?php $form = SearchForm::begin(); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'role') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?= $form->field($model, 'fullname') ?>

    <?php // echo $form->field($model, 'country_id') ?>

    <?php // echo $form->field($model, 'state_id') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php SearchForm::end(); ?>

</div>
