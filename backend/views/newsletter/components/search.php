<?php

use common\widgets\form\DatePickerRange;
use common\widgets\form\SearchForm;

?>

<div class="newsletter-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'subject') ?>

        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'body') ?>

        </div>
    </div>

    <?php SearchForm::end(); ?>
    
</div>
