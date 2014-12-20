<?php

use yii\helpers\Html;
use app\widgets\SearchForm;

?>

<div class="country-search">

    <?php $form = SearchForm::begin(); ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'code') ?>

    <?php SearchForm::end(); ?>

</div>
