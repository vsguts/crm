<?php

use yii\helpers\Html;
use common\widgets\form\SearchForm;

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
