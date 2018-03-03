<?php

use app\widgets\form\SearchForm;

/** @var \app\models\search\CountrySearch $model */

?>

<div class="country-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'name') ?>
        
        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'code') ?>

        </div>
    </div>

    <?php SearchForm::end(); ?>

</div>
