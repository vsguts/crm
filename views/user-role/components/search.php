<?php

use yii\helpers\Html;
use app\widgets\SearchForm;

?>

<div class="user-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'name') ?>

            <?= $form->field($model, 'email') ?>
        
        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'status')->dropDownList($model->getLookupItems('status', ['empty' => 'label'])) ?>

            <?= $form->field($model, 'role')->dropDownList($model->getLookupItems('role', ['empty' => 'label'])) ?>

        </div>
    </div>

    <?php SearchForm::end(); ?>

</div>
