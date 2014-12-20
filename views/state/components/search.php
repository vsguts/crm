<?php

use yii\helpers\Html;
use app\widgets\SearchForm;

?>

<div class="state-search">

    <?php $form = SearchForm::begin(); ?>

    <?= $form->field($model, 'country_id')->dropDownList($model->getList('Country', 'name', ['empty' => __('Country')])) ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'code') ?>

    <?php SearchForm::end(); ?>

</div>
