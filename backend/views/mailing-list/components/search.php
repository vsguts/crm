<?php

use common\widgets\form\SearchForm;

?>

<div class="mailing-list-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'status')->dropDownList($model->getLookupItems('status', ['empty' => true])) ?>

        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'sender') ?>

        </div>
    </div>

    <?php SearchForm::end(); ?>

</div>
