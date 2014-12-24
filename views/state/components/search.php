<?php

use yii\helpers\Html;
use app\widgets\SearchForm;

?>

<div class="state-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'country_id')->dropDownList($model->getList('Country', 'name', ['empty' => __('Country')])) ?>

            <?= $form->field($model, 'name') ?>
        
        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'code') ?>

        </div>
    </div>

    <?php SearchForm::end(); ?>

</div>
