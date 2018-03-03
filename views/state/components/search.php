<?php

use app\models\Country;
use app\widgets\form\SearchForm;

?>

<div class="state-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'country_id')->dropDownList(Country::find()->scroll(['empty' => true])) ?>

            <?= $form->field($model, 'name') ?>
        
        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'code') ?>

        </div>
    </div>

    <?php SearchForm::end(); ?>

</div>
